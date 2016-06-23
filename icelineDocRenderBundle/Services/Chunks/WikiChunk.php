<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services\Chunks;

use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
use icelineLtd\icelineLtdDocRenderBundle\ConfigInterface;
use icelineLtd\icelineLtdDocRenderBundle\Services\Chunks\ProgrammaticChunk;

/**
 * ChunkInterface 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class WikiChunk extends ProgrammaticChunk implements ChunkInterface
{
	protected $conf;
	
	/**
	 * setConf
	 * 
	 * @param ConfigInterface $ci 
	 * @return <self>
	 */
	function setConf(ConfigInterface $ci) {
		$this->conf=$ci;
		return $this;
	}
	
	
	/**
	 * getChunkType ~
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return [self::WIKI];
	}

	/**
	 * unpack ~ 
	 * 
	 * @param string $data 
	 * @return <new object>
	 */
	function unpack($data, $name, $filter) {
		
		return new self($name, $data, self::getChunkType(), $filter);
	}

	/**
	 * validate
	 * 
	 * @return bool
	 */
	function validate() {
		if( $this->conf->get(array('site_settings', 'markup_ascii_quotes')) ) {
				$this->data				= preg_replace('/"\b/', '“', $this->data);
				$this->data				= preg_replace('/\b"/', '”', $this->data);
// and more?
		}
		return true;
	}
	
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
