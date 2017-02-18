<?php

namespace icelineLtd\icelineDocRenderBundle\Services;

use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk;
use icelineLtd\icelineDocRenderBundle\PagesCollectionInterface;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineDocRenderBundle\Exceptions\AddFileException;

/**
 * ResourceHash
 * Save functionality isn't included in this version 
 * 
 * @uses ResourceInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class ResourceHash implements ResourceInterface
{
	protected $impl;
	protected $pages;
	
	protected $chunks;
	protected $directKeys;	
	protected $offset;
	protected $name;

	/**
	 * __construct
	 * 
	 * @return <self>
	 */
	function __construct() {
		$this->impl=[];
		$this->pages=[];
		$this->offset=0;
		$this->chunks=[];
		$this->directKeys=[];
		$this->name='UNKNOWN!';
	}

	function __clone() {
		$this->offset=0;
		$this->chunks=[];
		$this->directKeys=[];
		$this->name="UNKNOWN!";

		foreach($this->impl as $i=>$v) {
			$this->impl[$i]=clone $this->impl[$i];
			if(get_class($this->impl[$i]) == '\icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk' ) {
				$this->impl[$i]->setResource($this);
			}
		}
		if($this->pages) {
			$this->pages=clone $this->pages;
		}
	}

	/**
	 * setWorker
	 * 
	 * @param ChunkInterface $ct 
	 * @return <self>
	 */
	function setWorker(ChunkInterface $ct) {
		$types=$ct::getChunkType();
		if(!is_array($types)) { $types=[$types]; }

		foreach($types as $v) {
			$this->impl[ $v] =$ct;
		}
		return $this;
	}

	/**
	 * setPageCollection
	 * 
	 * @param PagesCollectionInterface $pci 
	 * @return <self>
	 */
	function setPageCollection(PagesCollectionInterface $pci) {
		$this->pages=$pci;
		return $this;		
	}
	
	/**
	 * setContentFromFile
	 * 
	 * @param string $fn 
	 * @throws BadResourceException
	 * @return void 
	 */
	public function setContentFromFile($fn) {
		if(!( is_file($fn) &&
			  is_readable($fn) &&
			  strpos($fn, '.wiki')==strlen($fn)-5)) {
			throw new BadResourceException("Attempt to use invalid file $fn");
		}
		$this->name=basename($fn, '.wiki');
		return $this->setContent(file_get_contents($fn));
	}
	
	/**
	 * setContent
	 * 
	 * @param string $data 
	 * @throws BadResourceException
	 * @return void 
	 */
	public function setContent($data) {
		$list=$this->_chunkify($data);
		$this->chunks=[];
		$this->directKeys=[];
		$LENGTH=count($list);
		for($i=0; $i<$LENGTH; $i++) {
			if(isset($this->impl[ $list[$i]['type'] ])) {
				try {
					$this->chunks[$i]=$this->impl[ $list[$i]['type'] ]->unpack($list[$i]['data'], $list[$i]['name'], $list[$i]['type'] )
											->setFormat($list[$i]['type']);
					if(!$this->chunks[$i]->validate()) {
						throw new BadResourceException("Chunk ".$list[$i]['name']." was bad.");
					}
					if($list[$i]['name']) {
						$this->directKeys[ $list[$i]['name'] ]=count($this->chunks)-1;
					} elseif(!isset($this->directKeys[ $list[$i]['type'] ])) {
						$this->directKeys[ $list[$i]['type'] ]=count($this->chunks)-1;	
					}

				} catch(AddFileException $afe) {
					$new=$afe->getResourceFile();
					if($this->pages->exists($new)) {
						// AFAIK its ok to append new data into the end, but check this
						$newData=file_get_contents($this->pages->toFile($new));
						$list=array_merge($list, $this->_chunkify($newData));
						$LENGTH=count($list);
					}
				}
 			} else {
				throw new BadResourceException("Unknown chunk type for ".$list[$i]['name']." type=".$list[$i]['type']."=");
			}
		}
		return $this;
	}

	/**
	 * getChunk
	 * 
	 * @param string $name 
	 * @return ChunkInterface || null
	 */
	public function getChunk($name):?ChunkInterface {
		if(isset($this->directKeys[$name])) {
			return $this->chunks[ $this->directKeys[$name] ]; 
		}
		if(isset($this->chunks[$name])) {
			return $this->chunks[$name];
		}
		return null;
//		throw new BadResourceException("Unknown chunk requested $name ");
	}

	/**
	 * setChunkRaw
	 * 
	 * @param string OR int $name 
	 * @param mixed $value 
	 * @param string $format OPTIONAL default=wiki
	 * @param string $filter OPTIONAL default=null
	 * @return <self>
	 * @assert $obj->setChunk("ssdf", "gdgdg", 'wiki', false) == $obj
	 * @assert $obj->setChunk(1, "gdgdg", 'wiki', false) == $obj
	 * @assert $obj->setChunk(new StdClass(), "gdgdg", 'wiki', false) == $obj
	 * @assert $obj->setChunk(false, "gdgdg", 'wiki', false) == $obj
	 */
	public function setChunkRaw($name, $value, $format='wiki', $filter=false) {
		if(is_int($name)) {
			$this->chunks[$name]=new ProgrammaticChunk($name, $value, $format, $filter);
			return $this;
		}
		if(is_string($name)) {
			$this->chunks[]=new ProgrammaticChunk($name, $value, $format, $filter);
			$this->directKeys[$name]=count($this->chunks)-1;
			return $this; 
		}
		$this->chunks[]=new ProgrammaticChunk($name, $value, $format, $filter);
		return $this; 
	}

	/**
	 * setChunk
	 * 
	 * @param string $name 
	 * @param ChunkInterface $chunk 
	 * @return <self>
	 * @assert $obj->setChunk("ssdf", $in) == $obj
	 * @assert $obj->setChunk(1, $in) == $obj
	 * @assert $obj->setChunk(new StdClass(), $in) == $obj
	 * @assert $obj->setChunk(false, $in) == $obj

	 */
	public function setChunk($name, ChunkInterface $chunk) {
		if(is_int($name)) {
			$this->chunks[$name]=$chunk;
			return $this; 
		}
		if(is_string($name)) {
			if(isset( $this->directKeys[$name])) {
				$this->chunks[ $this->directKeys[$name] ]=$chunk;
			} else {
				$this->chunks[]=$chunk;
				$this->directKeys[$name]=count($this->chunks)-1;
			}
			return $this; 
		}
		$this->chunks[]=$chunk;
		return $this;
	}

	/**
	 * addChunk
	 * 
	 * @param ChunkInterface $ci 
	 * @return <self>
	 */
	public function addChunk(ChunkInterface $ci) {
		$this->chunks[]=$ci;
		return $this;
	}
	
	/**
	 * appendChunk
	 * 
	 * @param string $name 
	 * @param string $value 
	 * @return <self>
	 * @assert $obji->appendChunk("f1", $in) == $obj  
	 */
	public function appendChunk($name, ChunkInterface $value) {
		if(isset($this->directKeys[$name])) {
			$this->chunks[ $this->directKeys[$name] ]->appendData($value->getData());
		} else {
			$this->chunks[]= $value;
			$this->directKeys[$name]=count($this->chunks)-1;
		}
		return $this;
	}
	
	/**
	 * merge
	 * 
	 * @param ResourceInterface $in 
	 * @return <self>
	 * @assert $obj->merge($in) == $in  
	 */
	public function merge(ResourceInterface $in) {
		$in->rewind();
		while($in->valid()) {
			$cur=$in->current();
			if($cur->getFormat()!==ChunkInterface::PAGE_META) {
				$this->setChunk($cur->getName(), $cur);
			}
			$in->next();
		}
		return $this;
	}
	
	/**
	 * getName
	 * 
	 * @return <self>
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * getAllChunks
	 * 
	 * @return an array of chunks
	 */
	public function getAllChunks():array {
		return $this->chunks;
	}

	/**
	 * getMetaAttrib ~ if chunk supports attribs, return requested data
	 * 
	 * @param string $name 
	 * @return <self>
	 */
	public function getMetaAttrib($name) {
		if(isset($this->directKeys['pagemeta'])) {
			return $this->chunks[ $this->directKeys['pagemeta'] ]->getAttribute($name);
		}
		return null;
	}
	

	
    /**
     * rewind
     * 
     * @return <self>
     */
    function rewind() {
        $this->offset = 0;
    }

    /**
     * current
     * 
     * @return <self>
     */
    function current() {
        return $this->chunks[$this->offset];
    }

    /**
     * key
     * 
     * @return <self>
     */
    function key() {
        return $this->offset;
    }

    /**
     * next
     * 
     * @return <self>
	 * this need a good unit test
     */
    function next() {
		$stay=true;
	 	++$this->offset;
		while($stay && $this->offset<count($this->chunks)) {
			$tt=$this->chunks[$this->offset]->getFormat();
			if(!$this->renderable($tt)) {
				$this->offset++;
			} else {
				$stay=false;
			}
		}
    }

    /**
     * valid
     * 
     * @return <self>
     */
    function valid() {
        return isset($this->chunks[$this->offset]);
    }

	/**
	 * renderable ~ an SRP isolated switch statement
	 * 
	 * @param string $name 
	 * @static
	 * @return <self>
	 */
	static function renderable($name) {
		$d=[ ChunkInterface::PAGE_META, 
	ChunkInterface::COMMENT,
	ChunkInterface::NEXT_RESOURCE,
	ChunkInterface::DO_GET,
	ChunkInterface::DO_POST ,
	ChunkInterface::POST_ARGS,
	ChunkInterface::GET_ARGS,
	ChunkInterface::PAGE_INCLUDE,
	 ];
		return !in_array($name, $d);
	}


	
	/**
	 * _chunkify ~ divide up raw buffer into the chunks
	 * Seperate to make testing easier
	 * 
	 * @param string data 
	 * @access private
	 * @return array
	 * @throws BadResourceException
	 */
	private function _chunkify($data) {{{
		$list							= array();
		$maxLen							= strlen($data);
		$nudge							= strlen(self::CHUNK_START);

		$low							= 0;
		$high							= 0;
		$listCount						= 0;
		while($high<$maxLen) {
			$low						= stripos($data, self::CHUNK_START, $high);
			if($low===false) {
				break;
			}
			$high						= stripos($data, self::CHUNK_END, $low);
			if($high===false) {
				break;
			}
			$low						+= $nudge; # the above boundary
			$high						-= $nudge; # the above boundary
			$high++; # its a less than comparison
			$chunk						= substr($data, $low, $high-$low); 
			$chunk						= trim($chunk);
			$chunk						= explode(self::LINE_ENDING, $chunk, 2);
			if(count($chunk)==1) { # no name, and 1 line :. not this format	
				throw new BadResourceException("Unable to locate chunk name/type.");	
			}
			if(trim($chunk[0])=='') {
				throw new BadResourceException("Unable to locate chunk name/type. ");
			}
			$chunk[0]					= preg_split('/[ \t]+/', $chunk[0], 3, PREG_SPLIT_NO_EMPTY);
			if(count($chunk[0])==1) {
				$chunk[0]				= [$chunk[0][0], ''];
			}
			$list[$listCount]			= [
											'type'=>strtolower($chunk[0][0]), 
											'name'=>$chunk[0][1], 
											'data'=>$chunk[1]
										];
			if(isset($chunk[0][2])) {
				$list[$listCount]['filter']=$chunk[0][2];
			} else {
				$list[$listCount]['filter']=false;
			}
			$listCount++;
			$high						+=2;
		}

		if(count($list) == 0 ) {
			throw new BadResourceException("Resource with no chunks.");
		}
		return $list;
	}}}	

	/**
	 * get_meta ~ I added this to reduce curve on updating files
	 * 
	 * @DEPRECATED
	 * @return <self>
	 */
	function get_meta() {
		return @$this->chunks[ $this->directKeys['pagemeta'] ];
	}
	
}

# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
