<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Render;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ChunkTransformInterface;

/**
 * JSRenderer
 * NOTEST
 * 
 * @uses ChunkTransformInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class CSSRenderer implements ChunkTransformInterface
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
		return [ChunkInterface::CSS,];
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
// strip the type attrib when happy there are no old browsers, its not needed for HTML5		
		return "<style type=\"text/css\">\n$text\n</style>";
	}
	
} 
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
