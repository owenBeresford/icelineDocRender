<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Chunks;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineDocRenderBundle\Services\PHPExecService;
use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;

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
	protected $conf;
	protected $resrc;
	protected $log;
	
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
	 * __destruct ~ needed as this is a deps loop
	 * 
	 * @return <self>
	 */
	function __destruct() {
		unset($this->resrc);
	}
	
	/**
	 * setConfig
	 * 
	 * @param ConfigInterface $ci 
	 * @return <self>
	 */
	function setConf(ConfigInterface $ci) {
		$this->conf=$ci;
		return $this;
	}

	/**
	 * setLog
	 * 
	 * @param LoggerInterface $log 
	 * @return <self>
	 */
	function setLog(LoggerInterface $log) {
		$this->log=$log;
		return $this;
	}

	/**
	 * setResource
	 * 
	 * @param ResourceInterface $ri 
	 * @return <self>
	 */
	function setResource(ResourceInterface $ri) {
		$this->resrc=$ri;
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
		// setting fail, so if error else where, it will crash
		return (new self($name, $data, "FAIL!", $filter))
				->setPHP($this->compile)
				->setConf($this->conf)
				->setLog($this->log)
				->setResource($this->resrc);
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
			$this->data=$this->compile->safeFunc($this->data, $this->name);
		}
 		return true;
	}		

	/**
	 * getData
	 * if this is a callable it executes it (for tables, tablists etc).
	 * if a page post/get dont run this here, as it will not have access to params 

	 * @return mixed, the unpacked chunk
	 */
	function getData() {
		if(!($this->type===self::DO_GET || $this->type===self::DO_POST)) {
			try {
				$t=$this->data;
				$fake1=[];
				$fake2=new \StdClass();
//	the params are:
// public function safeFunc($raw, $args='$log, &$request, &$ses, $conf, &$page')
				$ret= $t($this->log, $fake1, $fake2, $this->conf, $this->resrc);
				return $ret;
			} catch(\Exception $e ) {
				throw new BadResourceException("ERROR in ".$this->name." ".$e->getMessage());
			}
		} else {
			return $this->data;
		}
	}



}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
