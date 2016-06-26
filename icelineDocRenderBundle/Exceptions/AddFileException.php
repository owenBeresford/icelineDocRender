<?php

namespace icelineLtd\icelineDocRenderBundle\Exceptions;

/**
 * AddFileException 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class AddFileException extends \Exception
{
	protected $file;
	
	/**
	 * __construct
	 * 
	 * @param string $str 
	 * @param string $file 
	 * @return <self>
	 */
	function __construct($str, $file) {
		$this->file=$file;
		super::__construct($str);
	}
	
	/**
	 * getFile
	 * 
	 * @return string
	 */
	function getResourceFile(){
		return $this->file;
	}
}
