<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services\Transform;

use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
use icelineLtd\icelineLtdDocRenderBundle\ResourceInterface;
use icelineLtd\icelineLtdDocRenderBundle\TemplateRendererInterface;
use icelineLtd\icelineLtdDocRenderBundle\ChunkTransformInterface;
use icelineLtd\icelineLtdDocRenderBundle\ChunkRendererInterface;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\NoImplException;
use icelineLtd\icelineLtdDocRenderBundle\PagesCollectionInterface;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\BadResourceException;

/**
 * TemplateRenderer 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class FrameTransform implements TemplateRendererInterface
{
	protected $pages;

	/**
	 * __construct
	 * 
	 * @return <self>
	 */
	function __construct() {
	}
	
	/**
	 * setPageCollection
	 * 
	 * @param PageCollectionInterface $pci 
	 * @return <self>
	 */
	function setPageCollection(PagesCollectionInterface $pci) {
		$this->pages=$pci;
		return $this;
	}
	
	/**
	 * transform
	 * 
	 * @param ResourceInterface $in
	 * @access public
	 * @return ResourceInterface
	 * @throws BadResourceException ~ if the frame isn't valid
	 * @assert $obj->transform($in) == 'icelineLtd\icelineLtdDocRenderBundle\ResourceInterface'
	 * page without frame meta
	 * page with invalid frame 
	 */
	public function transform(ResourceInterface $in) {
		$meta=$in->getChunk(ChunkInterface::PAGE_META);
		$frame=$meta->getAttribute(ChunkInterface::FRAME);
		if($frame) {
			if(!$this->pages->exists($frame)) {
				throw new BadResourceException("Frame isn't valid" );
			}
			$frame=$this->pages->toFile($frame);
			$frame	= $this->pages->getResource($frame);
			$frame->merge($in);
			$frame->setChunk(ChunkInterface::PAGE_META, $meta);
			return $frame;
		}
		return $in;
	}

	/**
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @access public
	 * @return <self>
	 */
	public function render(ChunkInterface $ci) {
		throw new NoImplException(__CLASS__.'->'.__METHOD__ );
	}

}	
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
