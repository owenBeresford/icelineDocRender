<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services;

use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineLtdDocRenderBundle\ConfigInterface;
 use icelineLtd\icelineLtdDocRenderBundle\LogInterface;

/**
 * PHPExecService 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class PHPExecService
{
	
	protected $conf;
	protected $log;

	/**
	 * __construct
	 * 
	 * @return <object>
	 */
	function __construct( ) {		
		$this->conf=null;
		$this->log=null;
	}
	
	/**
	 * setConfig
	 * 
	 * @param ConfigInterface $ci 
	 * @return <this>
	 */
	function setConfig(ConfigInterface $ci) {
		$this->conf=$ci;
		return $this;
	}

	/**
	 * setLogger
	 * 
	 * @param LogInterface $l 
	 * @return <this>
	 */
	function setLogger(LogInterface $l) {
		$this->log=$l;
		return $this;
	}
	
	/**
	 * _safe_func - may need to move this
	 * 
	 * @access protected
	 * @param string $raw, PHP source of fucntion definition 
	 * @param string $args, PHP source of what the function will take, OPTIONAL
	 * @return the callable
	 * @throws BadResourceException
	 * @assert $obj->safeFunc(";") == Exception
	 * @assert $obj->safeFunc("return false;") == callable
	 * @assert $obj->safeFunc("return false") == Exception
	 * @assert $obj->safeFunc("throw new \Exception();") == callable
	 */
	public function safeFunc($raw, $args='$log, &$request, &$ses, $conf, &$page') {
		try {
			error_reporting(0);
#  i have to wipe here, due to bugs in imported libaries 
			$GLOBALS['error']		= 0; 
			$func					= create_function($args, $raw);
			$tt						= error_get_last();
			if($tt) {
# the following is necessary as some of the imported libraries are written to older PHP
				$this->log->debug($tt['message']." ".basename($tt['file']).'#'.$tt['line'], Log::LOG_NOTICE);
			}
			if($GLOBALS['error']>0) {
//				if(strpos( $tt['file'],'import' )===false) {
//					$this->ses->prepend_msg("Error in resource function '".$tt['message']."' ".basename($tt['file']).'#'.$tt['line']);
//				}
				throw new BadResourceException("Error running function attached to resource (see log)");
			}
			$GLOBALS['error']		= 0;

			error_reporting(-1 ^ E_DEPRECATED);
		} catch (\Exception $e) {
# attempt to tidy up syntax errors
			throw new BadResourceException($e->getMessage());
		} catch (\Error $ee) {
# attempt to tidy up syntax errors
			throw new BadResourceException($ee->getMessage());
		}
		if(!is_callable($func)) {
			$GLOBALS['error']		= 1;
			throw new BadResourceException("Internal error: page '".$this->name."' crashed on compilation, please contact an administrator.");
		}
		return $func;
	}
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
