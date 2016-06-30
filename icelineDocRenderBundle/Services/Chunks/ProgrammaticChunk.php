<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Chunks;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineDocRenderBundle\Exceptions\NoImplException;


/**
 *  ProgrammaticChunk  
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class ProgrammaticChunk implements ChunkInterface
{
	protected $name;
	protected $data;
	protected $type;
	protected $filter;

	/**
	 * getChunkType ~ this class should never be injected into the Facade
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return null;
	}
	
	/**
	 * __construct
	 * 
	 * @param mixed $name 
	 * @param mixed $data 
	 * @param mixed $type 
	 * @param mixed $filter 
	 * @return <self>
	 */
	function __construct($name, $data, $type='wiki', $filter=false) {
		$this->name=$name;
		$this->data=$data;
		$this->type=$type;
		$this->filter=$filter;
	}
	
	/**
	 * unpack ~ transform data into internal structure
	 * 
	 * @param string $data 
	 * @return bool
	 */
	function unpack($data, $name, $filter) {
		throw new NoImplException("This is stupid.");
	}

	/**
	 * validate
	 * 
	 * @return bool
	 */
	function validate() {
		throw new NoImplException("This is stupid.");		
	}

	/**
	 * getName
	 * 
	 * @return string of name
	 */
	function getName() {
		return $this->name;		
	}

	/**
	 * getData

	 * @return mixed, the unpacked chunk
	 */
	function getData() {
		return $this->data;
	}

	/**
	 * getAttribute ~ if chunk supports attribs, return requested data
	 * 
	 * @param string $name 
	 * @return mixed, probably a string. || null if unknown 
	 */
	function getAttribute($name) {
		if(is_array($this->data) && isset($this->data[$name])) {
			return $this->data[$name];
		}
		return null;
	}

	function getFormat() {
		return $this->type;
	}

	
	/**
	 * setFormat
	 * 
	 * @param mixed $in 
	 * @return <self>
	 */
	function setFormat($in) {
		$this->type=$in;
		return $this;
	}
	
	/**
	 * appendData
	 * 
	 * @notice only applies to strings 
	 * @param string $new 
	 * @return <self>
	 */
	function appendData($new) {
		if(gettype($this->data)=='string') {
			$this->data.=$new;
		}
		return $this;
	}
	
	/**
	 * setData
	 * 
	 * @param mixed $new 
	 * @return <self>
	 */
	function setData($new) {
		$this->data=$new;
		return $this;
	}
	
	
	/**
	 * unpackList
	 * 
	 * @param string $lump 
	 * @param string $bound (likely 1 char)
	 * @return <self>
	 */
	function unpackList($lump, $bound=ResourceInterface::VALUE_LIST_SPLIT) {{{
		if($lump) {
			$t		= explode($bound, trim($lump));
			foreach($t as $k=>$v) {
				if(trim($v)=='') {
					unset($t[$k]);
				}	
			}
			return $t;
		} else {
			return '';
		}
	}}}
	
	/**
	 * _request_mapper ~ utility function to convert English into ints
	 * 
	 * @param string $in 
	 * @access protected
	 * @return int
	 * @throws BadResourceException
	 */
	function requestMapper($in) {
		if( $in=='GET') {
			return ResourceInterface::HTTP_GET;
		} else if( $in=='POST') {
			return ResourceInterface::HTTP_POST;
		} else if( $in=='EITHER' ) {
			return ResourceInterface::HTTP_EITHER;
		} else {
			throw new BadResourceException("Unknown access method '$in'.");
		}
	}

} 
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
