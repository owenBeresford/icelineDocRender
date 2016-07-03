<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Chunks;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineDocRenderBundle\AddFileException;

/**
 * IncludeChunk 
 * 
 * @package 
 * NOTEST
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class IncludeChunk extends ProgrammaticChunk implements ChunkInterface
{
	
	/**
	 * getChunkType ~ 
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return [self::PAGE_INCLUDE];
	}

	/**
	 * unpack ~ 
	 * 
	 * @param string $data 
	 * @return <GetArgsChunk>
	 */
	function unpack($data, $name, $filter) {
		$data=trim($data);
		throw new AddFileException("This text isn't used", $data);
	}

	/**
	 * validate ~ this is validated else where...
 	 * 
	 * @return bool
	 */
	function validate() {
 		return true;
	}		

}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
