<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Chunks;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;

/**
 *  PlainChunk 
 * 
 * @package
 * NOTEST 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class PlainChunk extends ProgrammaticChunk implements ChunkInterface
{
	
	/**
	 * getChunkType ~ 
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return [self::PLAIN, self::HTML, self::CSS, self::JS];
	}

	/**
	 * unpack ~ 
	 * 
	 * @param string $data 
	 * @return bool
	 */
	function unpack($data, $name, $filter) {
		return new self($name, $data, self::getChunktype(), $filter);
	}

	/**
	 * validate
	 * 
	 * @return <self>
	 */
	function validate() {
		return true;
	}
	
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
