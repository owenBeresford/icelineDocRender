<?php

namespace icelineLtd\icelineDocRenderBundle\Services;

use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use icelineLtd\icelineDocRenderBundle\PagesCollectionInterface ;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineDocRenderBundle\TemplateRendererInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface  ;
use icelineLtd\icelineDocRenderBundle\PageServiceInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

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
	protected $log;	
	protected $page;
	protected $cache;
	protected $caching;
	
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

	function setCache(CacheInterface $ci) {
		$this->cache=$ci;
		$this->caching=intval($ci->get(['site_settings', 'enable_cache']));
		return $this;
	}

	function setCollection(PagesCollectionInterface $pci) {
		$this->page=$pci;
		return $this;
	}  

	/**
	 * setSession
	 * 
	 * @param SessionInterface $s 
	 * @return <self>
	 */
	function setSession(SessionInterface  $s) {
		$this->sess=$s;
		return $this;		
	}

	/**
	 * setLog
	 * 
	 * @param LoggerInterface $l 
	 * @return <self>
	 */
	function setLog(LoggerInterface $l) {
		$this->log=$l;
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
			if($this->caching && $this->cache->hit($page)) {
				return $this->cache->entry();
			} else {
				$this->resrc->setContentFromFile($page);
				for($i=0, $LENGTH=count($this->impl); $i<$LENGTH; $i++) {
					$this->resrc=$this->impl[$i]->transform($this->resrc);
				}

				$t=$this->resrc->getChunk(ChunkInterface::ROOTNAME);
				if(null===$t) {
					$this->log->info("INFO Can't find root element in $page ");
					return 500;
				} else {
					// dont cache pages requiring param data... 
					if($this->caching) {
						$this->cache->put($page, $t->getData());
					}
					return $t->getData();
				}
			}
			
		} catch(BadResourceException $bre) {
			$this->log->info($bre->getMessage());
			if(!$this->whine) {
				return 500;
			} else {
				if(isset($this->sess) && is_object( $this->sess)) {
					$this->sess->set('error-messages', array_merge([$bre->getMessage()], $this->sess->get('error-messages', []) ));
				}

				$this->whine=false;
				return $this->render($this->page->toFile($this->conf->get(['site_settings', 'error_template'])));
			}
		}
		throw new NoImplException("this state can't happen ".__CLASS__.'#'.__LINE__);
	}
	
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
