<?php

namespace icelineLtd\icelineDocRenderBundle\Services; 

use icelineLtd\icelineDocRenderBundle\PagesCollectionInterface;
use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;

/**
 * PageCollection 
 * Maybe should be extended for caching code
 * 
 * @uses PagesCollectionInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class PageCollection implements PagesCollectionInterface
{
	protected $resrc;
	protected $conf;
	protected $pages;
	protected $projectRoot;

	/**
	 * __construct
	 * 
	 * @param ConfigInterface $ci 
	 * @return <object>
	 */
	public function __construct(ConfigInterface $ci) {
		$this->conf=$ci;
		$this->pages=[];
		$this->projectRoot=realpath(__DIR__.'/../../../').'/';
		$list=glob( $this->projectRoot.$this->conf->get(['site_settings','res_dir']).'*.wiki');
		foreach($list as $k=>$v) {
		// IOIO I think I need more stuff here...
			$this->pages[basename($v, ".wiki")]=$v;
		}
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
	 * toURL
	 * 
	 * @param mixed $name 
	 * @return string
	 */
	public function toURL($name) {
		return "http://".$this->conf->get(['site_settings','site_baseurl']).
						$this->conf->get(['site_settings','resource_dir']).
						$name;
	}

	/**
	 * toFile
	 * 
	 * @param mixed $name 
	 * @return string
	 */
	public function toFile($name) {
		return realpath($this->projectRoot.$this->conf->get(['site_settings','res_dir']).'/'.$name.'.wiki');
	}
	
	/**
	 * all
	 * 
	 * @return array of file names
	 * @assert is_array($obj->get())
	 * @assert count($obj->get()) >0
	 * @assert $obj->get()[0] match '.wiki'
	 */
	function all() {
		return $this->pages;
	}

	/**
	 * getResource
	 * 
	 * @param mixed $name 
	 * @return <ResourceHash>
	 */
	function getResource($name=null) {
		$rh= clone $this->resrc;
		if($name!==null) {
			if(strpos($name, '/')===false) {
				$name=$this->toFile($name);
			}
			$rh->setContentFromFile($name);
		}
		return $rh;
	}

	/**
	 * exists
	 * 
	 * @param string $name 
	 * @return bool
	 */
	public function exists($name) {
		return array_key_exists($name, $this->pages);
	}
		
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php

