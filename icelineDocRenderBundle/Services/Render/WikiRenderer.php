<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Render;

use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use icelineLtd\icelineDocRenderBundle\WikiFactoryInterface;
use icelineLtd\icelineDocRenderBundle\ChunkInterface; 
use icelineLtd\icelineDocRenderBundle\ChunkTransformInterface;

/**
 * WikiRenderer 
 * NOTEST
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class WikiRenderer implements ChunkTransformInterface
{
	protected $wiki;
	protected $wikiformat;
	
	/**
	 * __construct
	 * 
	 * @param mixed $format 
	 * @return <self>
	 */
	function __construct($format) {
		$this->wikiformat=$format;
	}
		
	/**
	 * setWiki
	 * 
	 * @param WikiFactoryInterface $wfi 
	 * @return <self>
	 */
	function setWiki(WikiFactoryInterface $wfi) {
		$this->wiki=$wfi->get();
		return $this;
	}
	
	/**
	 * getChunkType
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return [ChunkInterface::WIKI];
 	}

	/**
	 * setFormat,
	 * 
	 * @param string $in 
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
	 * Cannot semantically unit-test a HTML fix in a unittester.  Needs to be done in a design tool.
	 */
	public function render(ChunkInterface $ci) {
		$text=$ci->getData();

		$text						= $this->wiki->transform($text, $this->wikiformat);
		$text = str_replace(" onclick=\"window.open(this.href, '_blank'); return false;\"", " target=\"_blank\"", $text);
		$text = preg_replace("/<h([1-6]) id=\"([^\"]*)\">([^<]*)<a id=\"([^\"]*)\"><\/a><\/h[1-6]>/", "<h$1 id=\"$4\">$3</h$1>", $text );
		return $text;
	}
	
} 
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
