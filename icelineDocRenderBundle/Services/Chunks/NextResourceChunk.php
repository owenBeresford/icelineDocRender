<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services\Chunks;

use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
use icelineLtd\icelineLtdDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineLtdDocRenderBundle\ResourceInterface;

/**
 * NextResourceChunk 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class NextResourceChunk extends ProgrammaticChunk implements ChunkInterface
{
	
	/**
	 * getChunkType ~ 
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return [self::NEXT_RESOURCE];
	}

	/**
	 * unpack ~ 
	 * 
	 * @param string $data 
	 * @return <GetArgsChunk>
	 */
	function unpack($data, $name, $filter) {
		$data=trim($data);
		$data=$this->unpackList($data, ResourceInterface::LIST_SPLIT);
		return new self($name, $data, self::getChunkType(), $filter);
	}

	/**
	 * validate
	 * 
	 * @return bool
	 */
	function validate() {
 		return true;
	}		

}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
