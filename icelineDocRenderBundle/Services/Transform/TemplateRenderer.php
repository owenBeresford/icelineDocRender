<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services\Transform;

use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
use icelineLtd\icelineLtdDocRenderBundle\ResourceInterface;
use icelineLtd\icelineLtdDocRenderBundle\ChunkTransformInterface;
use icelineLtd\icelineLtdDocRenderBundle\ChunkRendererInterface;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineLtdDocRenderBundle\TemplateRendererInterface;
use icelineLtd\icelineLtdDocRenderBundle\Services\StaticValuesFactory ;
use icelineLtd\icelineLtdDocRenderBundle\Services\ResourceHash ;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\NoImplException;

/**
 * TemplateRenderer 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class TemplateRenderer implements TemplateRendererInterface
{
	protected $impl;
	protected $replacements;
	
	/**
	 * __construct
	 * 
	 * @return <self>
	 */
	function __construct() {
		$this->impl=[];
		$this->replacements=[];
	}
	
	/**
	 * setStaticsFactory
	 * 
	 * @param StaticValuesFactory $svf 
	 * @return <self>
	 */
	function setStaticsFactory(StaticValuesFactory $svf) {
		$this->impl[$svf::NAME]=$svf;
		return $this;
	}

	/**
	 * setWorker
	 * 
	 * @param ChunkTransformInterface $cti 
	 * @return <self>
	 * @assert $obj->setWorker(new X) == 'the class'
	 * add several more setWorkers
	 */
	function setWorker(ChunkTransformInterface $cti) {
		$t=$cti->getChunkType();
		if(!is_array($t)) { $t=[$t]; }
		foreach($t as $v) {
			$this->impl[$v]=$cti->setFormat($v);
		}
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
	public function transform(ResourceInterface $ri) {
		$out=$this->impl[StaticValuesFactory::NAME]->get($ri);
		$this->replacements=[];
		
		$ri->rewind();
		while($ri->valid()) {
			$t=$ri->current();
			if(ResourceHash::renderable($t->getFormat())) {
				$tout=$this->impl[$t->getFormat()]->render($t);
				$out->addChunkRaw($t->getName(), $tout, ChunkInterface::HTML);
			
				$this->extractMap($tout);
			}
			$ri->next();
		}
		
		$map=$this->mapValues($this->replacements, $ri, $out);
		$out=$this->applyMap($map, $out);
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
		if(preg_match_all('/'.preg_quote(ResourceInterface::MARKER_START).'([^\]]+)'.preg_quote(ResourceInterface::MARKER_END).'/', $tout, $matches)) {
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
	function mapValues(array $names, ResourceInterface $in, ResourceInterface $out) {
		$map=[];
		for($i=0, $LENGTH=count($names); $i<$LENGTH; $i++) {
			$marker=ResourceInterface::MARKER_START.$names[$i].ResourceInterface::MARKER_END;
			$map[ $marker ] = $out->getChunk($names[$i]);
			if($map[ $marker ] !== null) {
				$map[ $marker ]=$in->getChunk($names[$i] );
			}
			if($map[ $marker ] !== null) {
				throw new BadResourceException("Unknown chunk ".$names[$i]);
			}
		}
		return $map;
	}

	/**
	 * applyMap
	 * 
	 * @param array $map 
	 * @param ResourceInterface $out 
	 * @return array
	 * @assert $obj->applyMap(['test001'=>"dgdgdfgdf"], $out) == 'array'
	 */
	function applyMap(array $map, ResourceInterface $out) {
		$keys=array_keys($map);
		$values=array_values($map);
		
		$out->rewind();
		while($out->valid()) {
			$cur=$out->current();
			$t=$cur->getData();
			if(gettype($t)=='string') {
				$t=str_replace($keys, $values, $t);
				$out->setChunk($cur->getName(), $cur->setData($t));
			}
			$out->next();
		}
		return $out;
	}


	
	/**
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @access public
	 o* @return <self>
	 */
	public function render(ChunkInterface $ci) {
		if(isset($this->impl[$ci->getFormat()])) {
			return $this->impl[$ci->getFormat()]->render($ci);
		} else {
			throw new NoImplException("Have no registered handler for ".$ci->getFormat());
		}
	}

}	
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
