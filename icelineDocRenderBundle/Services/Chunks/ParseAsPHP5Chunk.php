<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Chunks;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineDocRenderBundle\Services\PHPExecService;

/**
 * ParseAsPHP5Chunk 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class ParseAsPHP5Chunk extends ProgrammaticChunk implements ChunkInterface
{

	protected $compile;
	
	/**
	 * setPHP
	 * 
	 * @param PHPExecService $pes 
	 * @return <self>
	 */
	function setPHP(PHPExecService $pes) {
		$this->compile=$pes;
		return $this;
	}
	
	/**
	 * getChunkType ~ 
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return [self::PHP5, self::TABLE, self::DO_GET, self::DO_POST, self::TABLIST, self::FORM];
	}

	/**
	 * unpack ~ 
	 * 
	 * @param string $data 
	 * @return <new object>
	 */
	function unpack($data, $name, $filter) {
		return new self($name, $data, "FAIL!", $filter);
	}

	/**
	 * validate
	 *
	 * @throws BadResourceException 
	 * @return bool
	 */
	function validate() {
		$this->data=trim($this->data);
		if(!function_exists($this->data)) {
			$this->data=$this->compile->safeFunc($this->data);
		}
 		return true;
	}		

}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
