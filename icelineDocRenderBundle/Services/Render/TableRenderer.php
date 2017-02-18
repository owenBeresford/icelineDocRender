<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Render;

use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ChunkTransformInterface;
use icelineLtd\icelineDocRenderBundle\Exception\BadResourceException ;
use icelineLtd\icelineDocRenderBundle\Services\HTMLise; 

/**
 * TableRenderer 
 * 
 * @uses ChunkTransformInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class TableRenderer implements ChunkTransformInterface
{
	protected $conf;
	protected $template;
	protected $file;
	protected $htmlise; 
	protected $format;
	
	function __construct() {
	}
		
	/**
	 * setConfig
	 * 
	 * @param ConfigInterface $c 
	 * @return <self>
	 */
	function setConfig(ConfigInterface $c) {
		$this->conf=$c;
		// import settings
		return $this;
	}
		
	/**
	 * setHTMLise
	 * 
	 * @param HTMLise $h 
	 * @return <self>
	 */
	function setHTMLise(HTMLise $h) {
		$this->htmlise=$h;
		$this->htmlise->setConfig($this->conf);
		return $this;
	}

	/**
	 * setFormat
	 * 
	 * @param string $in 
	 * @access public
	 * @return <self>
	 */
	public function setFormat($in) {
		$this->format=$in;
		return $this;
	}


	/**
	 * getChunkType
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType():array {
		return [ChunkInterface::TABLE];
 	}

	/**
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @return string
	 * @throws BadResourceException
	 * @assert $obj->render($in) == 'string'
	 */
	public function render(ChunkInterface $ci):string {
		$data=$ci->getData();
		
		$titles				= [];
		$styles				= [];
		$id					= '';
		if(!is_array($data)) { 
# may need to revise this ...
			$data				=$data();
		}
		if(array_key_exists('titles', $data)) {
			$titles			= $data['titles'];
		} elseif(gettype( reset($data[0])) =='string') {
			$titles			= array_keys($data[0]);
		}
		if(array_key_exists('styles', $data)) {
			$styles			= $data['styles'];
		}
		if(array_key_exists('id', $data)) {
			$id				= $data['id'];
		}
		$this->htmlise->setStyles($styles);		
		if(  $this->htmlise->make_table($data, $titles, $id) !=0) {
			throw new BadResourceException($nm);
		}
		return $this->htmlise->get_buffer();		
	}
	
} 
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
