<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Chunks;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;

/**
 * CommentChunk
 * 
 * @package 
 * NOTEST
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class CommentChunk extends ProgrammaticChunk implements ChunkInterface
{
	
	/**
	 * getChunkType ~ this class should never be injected into the Facade
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return self::COMMENT;
	}

	/**
	 * unpack ~ nthing in a comment
	 * 
	 * @param string $data 
	 * @return bool
	 */
	function unpack($data, $name, $filter) {		
		return new self($name, $data, self::getChunkType(), $filter);
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
