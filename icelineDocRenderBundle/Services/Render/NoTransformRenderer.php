<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services\Render;

 use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
  use icelineLtd\icelineLtdDocRenderBundle\ChunkTransformInterface;

/**
 * NoTransformRenderer 
 * 
 * @uses ChunkTransformInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class NoTransformRenderer implements ChunkTransformInterface
{
	protected $format;
	
	function __construct() {
	}
			
	/**
	 * getChunkType
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return [ChunkInterface::PLAIN, ChunkInterface::HTML, ChunkInterface::PHP5 ];
 	}

	/**
	 * setFormat
	 * 
	 * @param mixed $in 
	 * @access public
	 * @return <self>
	 */
	public function setFormat($in) {
		$this->format=$in;
		return $this;
	}

	/**
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @return string
	 */
	public function render(ChunkInterface $ci) {
		$text=$ci->getData();
		if($this->format=='plain') {
			$text=htmlentities($text,  ENT_NOQUOTES );
		}
		return $text;
	}
	
} 
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
