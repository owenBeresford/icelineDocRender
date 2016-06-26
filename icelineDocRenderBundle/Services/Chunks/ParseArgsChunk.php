<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Chunks;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;

/**
 * ParseArgsChunk  
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class ParseArgsChunk extends ProgrammaticChunk implements ChunkInterface
{
	
	/**
	 * getChunkType ~ 
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return [self::GET_ARGS, self::POST_ARGS];
	}

	/**
	 * unpack ~ 
	 * 
	 * @param string $data 
	 * @return <GetArgsChunk>
	 */
	function unpack($data, $name, $filter) {
		$data=trim($data);
		$data=explode($data,icelineLtd\icelineDocRenderBundle\ResourceInterface::LIST_SPLIT );
		
		return new self($name, $data, self::getChunkType(), $filter);
	}

	/**
	 * validate
	 * 
	 * @return bool
	 */
	function validate() {
		if(count($this->data)==0) {
			return false;
		}
		foreach($this->data as $k=>$v) {
			$this->data[$k]=trim($this->data[$k]);
			if($this->data[$k]=='') {
				return false;				
			}
		}
 		return true;
	}		

}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
