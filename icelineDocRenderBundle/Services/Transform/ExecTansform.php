<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services\Transform;

use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
use icelineLtd\icelineLtdDocRenderBundle\ResourceInterface;
use icelineLtd\icelineLtdDocRenderBundle\ChunkTransformInterface;
use icelineLtd\icelineLtdDocRenderBundle\ChunkRendererInterface;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\NoImplException;
use icelineLtd\icelineLtdDocRenderBundle\TemplateRendererInterface;

/**
 * TemplateRenderer 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class ExecTransform implements TemplateRendererInterface
{
	protected $type;
	protected $log;
	protected $sess;
	protected $conf;

	/**
	 * __construct
	 * 
	 * @param string $type 
	 * @return <self>
	 */
	function __construct($type) {
		$this->type=$type;
		$this->conf=null;
		$this->log=null;
		$this->sess=null;
	}
	
	/**
	 * setConfig
	 * 
	 * @param ConfigInterface $ci 
	 * @return <self>
	 */
	function setConfig(ConfigInterface $ci) {
		$this->conf=$ci;
		return $this;
	}

	/**
	 * setLogger
	 * 
	 * @param LogInterface $l 
	 * @return <self>
	 */
	function setLogger(LogInterface $l) {
		$this->log=$l;
		return $this;
	}
	
	/**
	 * setSession
	 * 
	 * @param SessionInterface $s 
	 * @return <self>
	 */
	function setSession(SessionInterface $s) {
		$this->sess=$s;
		return $this;		
	}
	
	/**
	 * transform
	 * 
	 * @param ResourceInterface $in 
	 * @access public
	 * @return ResourceInterface
	 * @assert $obj->transform($in) == 'icelineLtd\icelineLtdDocRenderBundle\ResourceInterface'
	 * add tests for other http actions
	 * add tests for where there is no function
	 */
	public function transform(ResourceInterface $in) {
		$func=null;
		if($this->type=='GET') {
			$func=$in->getChunk(ChunkInterface::DO_GET);
		}
		if($this->type=='POST') {
			$func=$in->getChunk(ChunkInterface::DO_POST);
		}
		if($func==null) {
			return $in;
		}
		$ret=call_user_func($func->getData(),  $this->log, [], $this->sess, $this->conf, $in);
		if(!$ret) {
			throw new BadResourceException("Page function returned an error ");
		}
		return $in;
	}

	/**
	 * render
	 *
	 * NO IMPL in this class 
	 * @param ChunkInterface $ci 
	 * @access public
	 * @return <self>
	 */
	public function render(ChunkInterface $ci) {
		throw new NoImplException(__CLASS__.'->'.__METHOD__ );
	}

}	
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
