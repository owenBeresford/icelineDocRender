<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services\Chunks;

use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
use icelineLtd\icelineLtdDocRenderBundle\ConfigInterface;
use icelineLtd\icelineLtdDocRenderBundle\ResourceInterface;
use icelineLtd\icelineLtdDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\TypeConvertException;

/**
 * PageMetaChunk  
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class PageMetaChunk extends ProgrammaticChunk implements ChunkInterface
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
		return [self::PAGE_META];
	}

	/**
	 * unpack ~ 
	 * 
	 * @param string $data 
	 * @return <new object>
	 */
	function unpack($data, $name, $filter) {
		$data=$this->unpack_avps($data, ResourceInterface::MIMIMUM_AVP, true );
		
		return new self($name, $data, self::getChunktype(), $filter);
	}

	/**
	 * validate
	 *
 	 * @Todo move literals into the constants in the interface
	 * @throws BadResourceException
	 * @return <self>
	 */
	function validate() {
		$mandatory_header			=[ 'docversion', 'accessgroup', 'method', 'codeversion', ];		
		foreach($mandatory_header as $v) {
			if(!array_key_exists($v, $this->data)) {
				throw new BadResourceException("Missing required header items '$v'.");
			}
		}

# items needing extra behave: Method, DocVersion, CodeVersion, AccessGroup
		if(array_key_exists('accessgroup', $this->data)) {
			$this->data['accessgroup']		= intval( $this->data['accessgroup']);
		}
		if(array_key_exists('method', $this->data) ) {
			$this->data['method']				= $this->requestMapper( $this->data['method'] );
		}
		if(array_key_exists('codeversion', $this->data) ) {
#			$this->data['codeversion']		=floatval($this->data['codeversion']); 
# tripple dot, can't
			if(version_compare( $this->data['codeversion'], $this->conf->get(array('site_settings','platform_edition')), '>' ) ) {
	            throw new BadVersionException($this->data['codeversion'] );
			}
# Allow slippage of minor alterations for bug fixes....
			$t							= explode('.', $this->conf->get(array('site_settings','platform_edition')) );
			$t[2]						= 0;
			$t							= implode('.', $t);
			if(version_compare( $this->data['codeversion'], $t, '<' ) ) {
	            throw new BadResourceException("Page for different rendering edition, can't work.".$this->data['codeversion']."!=".$this->conf->get(array('site_settings','platform_edition')));
			}

		}	
		if(array_key_exists('docversion', $this->data) ) {
			$this->data['docversion']			= floatval($this->data['docversion']);
			if($this->data['docversion']!= ResourceInterface::MY_PAGE_EDITION) {
				throw new TypeConvertException("Content Error: unrecognised document version '".$this->data['docversion']."'.");
# needs to be a separate exception, so parsing several versions can be supported. 
#	            throw new BadResourceException("Content Error: unrecognised document version '".$this->data['docversion']."'.");
			}
		}
		if(array_key_exists('getopts', $this->data) && !is_array($this->data['getopts'])) {
			$this->data['getopts']			= $this->unpackList($this->data['getopts']);
		}
		if(array_key_exists('postopts', $this->data) && !is_array($this->data['postopts'])) {
			$this->data['postopts']			= $this->unpackList($this->data['postopts']);
		}
		if(array_key_exists('alternativepost', $this->data)) {
			if(!function_exists($this->data['alternativepost'])) {
				$f					=$this->conf->get(array('site_settings', 'site_dir'));
				$f					.="/".$this->data['alternativepost'].".php";
				if(file_exists($f )) {
					include_once($f);
				}
			}

			if(!function_exists($this->data['alternativepost'])) {
	        	throw new BadResourceException("Content Error: reference to badly defined fucntion '".$this->data['alternativepost']."'.");	
			}
		}	
		
		return true;
	}
	
	
	/**
	 * unpack_avps
	 * 
	 * @param string $meta 
	 * @param string $low 
	 * @param bool $distinct, default true 
	 * @throws BadResourceException
	 * @return array of data
	 */
	function unpack_avps($meta, $low, $distinct=true) {{{
		$avps							= [];
		$avpsraw						= explode(ResourceInterface::LIST_SPLIT, $meta);
		if(!is_array($avpsraw) || count($avpsraw)<$low) {			
			throw new BadResourceException("Unable to extract meta header");
		}

		foreach($avpsraw as $v) {
			$v							= trim($v);
			if($v=="") {
				continue;
			}
			if(strpos($v, ResourceInterface::AVP_SPLIT)!==FALSE) {
				$landr					= explode(ResourceInterface::AVP_SPLIT, $v, 2);
				if(count($landr)!=2) {
					throw new BadResourceException("Malformed meta header item.");
				}
				$landr[0]				= strtolower(trim($landr[0]));
				$landr[1]				= trim($landr[1]);
				if($distinct) {
					$avps[]				= array($landr[0], $landr[1]);
					
				} else {
					$avps[ $landr[0] ]	= $landr[1];
				}
			} else {
				if($distinct) {
					$avps[]				= array('', $v);
				} else {
					$avps[]				= $v;
				}
			}
		}
		return $avps;
	}}}
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
