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
	
	/**
	 * __construct
	 * 
	 * @return <self>
	 */
	function __construct() {
		$this->impl=[];
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
		$out=clone $ri;

		$ri->rewind();
		while($ri->valid()) {
			$t=$ri->current();
			if(ResourceHash::renderable($t->getFormat())) {
				if(! isset($this->impl[$t->getFormat()]) ) {
					throw new NoImplException("Unknown format ".$t->getFormat());
				}
				$tout=$this->impl[$t->getFormat()]->render($t);
				$out->setChunkRaw($t->getName(), $tout, ChunkInterface::HTML);
			}
			$ri->next();
		}
		$out->setChunk(ChunkInterface::PAGE_META, $ri->getChunk(ChunkInterface::PAGE_META));
		return $out;
	}
	
	/**
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @access public
	 * @return <self>
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
