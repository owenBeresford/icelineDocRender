<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Transform;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\ChunkTransformInterface;
use icelineLtd\icelineDocRenderBundle\ChunkRendererInterface;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineDocRenderBundle\TemplateRendererInterface;
use icelineLtd\icelineDocRenderBundle\Services\StaticValuesFactory ;
use icelineLtd\icelineDocRenderBundle\Services\ResourceHash ;
use icelineLtd\icelineDocRenderBundle\Exceptions\NoImplException;

/**
 * TemplateMerge 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class TemplateMerge implements TemplateRendererInterface
{
	protected $replacements;
	protected $static;
	
	/**
	 * __construct
	 * 
	 * @return <self>
	 */
	function __construct() {
		$this->static=null;
		$this->replacements=[];
	}

	/**
	 * setStaticsFactory
	 * 
	 * @param StaticValuesFactory $svf 
	 * @return <self>
	 */
	function setStaticsFactory(StaticValuesFactory $svf) {
		$this->static=$svf;
		return $this;
	}


	/**
	 * transform
	 * 
	 * @param ResourceInterface $ri 
	 * @access public
	 * @return <ResourceInterface>
	 * @assert $obj->transform($in) == 'the class'
	 * count AVP in each
	 */
	public function transform(ResourceInterface $ri):ResourceInterface  {
		$out=$this->static->get($ri);
		$out->merge($ri);
		$out->setChunk(ChunkInterface::PAGE_META, $ri->getChunk(ChunkInterface::PAGE_META));
		$this->replacements=[];

		$ri->rewind();
		while($ri->valid()) {
			$t=$ri->current();
			if(gettype($t->getData())=='string') {
				$this->extractMap($t->getData());
			}
			$ri->next();
		}	

		$map=$this->mapValues($this->replacements, $ri, $out);
		// apply applyMap() until there are no more replacement markers
		while($this->applyMap($map, $out)) {; }

		return $out;
	}

	/**
	 * extractMap ~ apply regex to extract named values
	 * 
	 * @param string $tout 
	 * @return void
	 * @assert $obj->extractMap("tst test [[test001]] test") == "the class"
	 */
	function extractMap($tout) {
		$matches=[];
		if(preg_match_all('/'.preg_quote(ResourceInterface::MARKER_START).'([^\]\[]+)'.preg_quote(ResourceInterface::MARKER_END).'/', $tout, $matches)) {
			for($i=0, $LENGTH=count($matches[1]); $i<$LENGTH; $i++) {
				$this->replacements[]=$matches[1][$i];
			}
		}	
		return $this;
	}
	
	/**
	 * mapValues ~ pull (from either param) all the values apply to a hash, return hash
	 * 
	 * @param array $names 
	 * @param ResourceInterface $in 
	 * @param ResourceInterface $out 
	 * @return hash of strings
	 * @throws BadResourceException ~ if unknown value requested
	 * @assert $obj->mapValues(['test001'], $in, $out) == 'array'
	 * @assert $obj->mapValues(['PANDA STYLE'], $in, $out) == 'array'
	 * for various values in in and out
	 */
	function mapValues(array $names, ResourceInterface $in, ResourceInterface $out):array {
		$map=[];
		$out2=[];
		for($i=0, $LENGTH=count($names); $i<$LENGTH; $i++) {
			$marker=ResourceInterface::MARKER_START.$names[$i].ResourceInterface::MARKER_END;
			$map[ $marker ] = $out->getChunk($names[$i]);
			if($map[ $marker ] === null) {
				$map[ $marker ]=$in->getChunk($names[$i] );
			}
			if($map[ $marker ] === null) {
				throw new BadResourceException("Unknown chunk ".$names[$i]);
			} else {
				$out2[$marker]=$map[$marker]->getData();
				if(is_object($out2[$marker]) /* && !is_callable($map[$marker]) */ ) {
					$out2[$marker]=$out2[$marker]->getData();	
				}
			}
		}
		return $out2;
	}

	/**
	 * applyMap
	 * 
	 * @param array $map 
	 * @param ResourceInterface $out 
	 * @return int
	 * @assert $obj->applyMap(['test001'=>"dgdgdfgdf"], $out) == 'array'
	 */
	function applyMap(array $map, ResourceInterface &$out):int {
		$keys=array_keys($map);
		$values=array_values($map);
		$changes=0;
		
		$out->rewind();
		while($out->valid()) {
			$cur=$out->current();
			$t=$cur->getData();
			if(gettype($t)==='string') {
				$t=str_replace($keys, $values, $t, $chng);
				$out->setChunk(	$cur->getName(), $cur->setData($t));
				$changes+=$chng;
			}
			$out->next();
		}
		return $changes;
	}


	
	/**
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @access public
	 o* @return <self>
	 */
	public function render(ChunkInterface $ci) {
		throw new NoImplException("Doesn't make sense to merge a single chunk");
	}

}	
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
