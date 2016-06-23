<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services;

use icelineLtd\icelineLtdDocRenderBundle\ResourceInterface;
use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
use icelineLtd\icelineLtdDocRenderBundle\ConfigInterface;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineLtdDocRenderBundle\TemplateRendererInterface;
# use icelineLtd\icelineLtdDocRenderBundle\PageServiceInterface;


/**
 * PageService 
 * 
 * @uses PageServiceInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class PageService implements PageServiceInterface
{
	protected $impl;
	protected $resrc;
	protected $whine;
	protected $conf;
	
	
	/**
	 * setDebug
	 * 
	 * @param string $in 
	 * @return <this>
	 */
	function setDebug($in) {
		$this->whine=boolval($in);
		return $this;
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
	 * setTransform
	 * 
	 * @param TemplateRendererInterface $tri 
	 * @return <this>
	 */
	function setTransform(TemplateRendererInterface $tri) {
		$this->impl[]=$tri;
		return $this;
	}
	
	/**
	 * setResource
	 * 
	 * @param ResourceInterface $ri 
	 * @return <this>
	 */
	function setResource(ResourceInterface $ri) {
		$this->resrc=$ri;
		return $this;
	}

	/**
	 * render
	 * 
	 * @param string $page 
	 * @access public
	 * @return int for fail, HTTP code OR string of computed resource
	 * @assert $obj->render('test001') == 'string'
	 * @assert $obj->render('PANDA_STYLE') == \Exception
	 * 
	 */
	public function render($page) {
		try {
			$this->resrc->setContentFromFile($page);
			for($i=0, $LENGTH=count($this->impl); $i<$LENGTH; $i++) {
				$this->resrc=$this->impl[$i]->transform($this->resrc);
			}
			return $this->resrc->getChunk(ChunkInterface::ROOTNAME)->getData();
			
		} catch(BadResourceException $bre) {
			if(!$this->whine) {
				return 500;
			} else {
				try {
					$this->sess->append(['error-messages'], $bre->getMessage());
					$this->resrc->setContentFromFile($this->conf->get(['site_settings', 'error_template']));
					for($i=0, $LENGTH=count($this->impl); $i<$LENGTH; $i++) {
						$this->resrc=$this->impl[$i]->transform($this->resrc);
					}				
					return $this->resrc->getChunk(ChunkInterface::ROOTNAME)->getData();
				} catch(\Exception $e) {
					return 500;
				}
			}
		}
	}
	
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
