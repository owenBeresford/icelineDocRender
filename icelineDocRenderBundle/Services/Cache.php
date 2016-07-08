<?php

namespace icelineLtd\icelineDocRenderBundle\Services;

use icelineLtd\icelineDocRenderBundle\CacheInterface;
use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use icelineLtd\icelineDocRenderBundle\Exceptions\NoImplException;

/**
 * Cache 
 * 
 * @uses CacheInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class Cache implements CacheInterface
{
	protected $page;
	protected $cache;

	/**
	 * __construct
	 * 
	 * @return <self>
	 */
	function __construct(ConfigInterface $ci) {

		$inTest=$ci->get(['site_settings','in_test']);
		$this->cache=__DIR__.'/../../../../'.$ci->get(['site_settings','cache_dir']);
		if($inTest && (!is_dir($this->cache) || !is_readable($this->cache) || !is_writable($this->cache))) {
			throw new NoImplException("Fix your directory permissions ".$this->cache);
		}

		$this->page=false;
	}

	/**
	 * hit
	 * 
	 * @param string $in 
	 * @return <self>
	 * @assert $obj->hit('PANDA') == false
	 * @assert $obj->hit('home') == true
	 */
	function hit($in) {
		$file=basename($in, '.wiki');
		$this->page=$this->cache.$file.".html";		
		if(!is_file($this->page)) {
			$this->page=false;
			return false;
		}
		clearstatcache();
		if(filemtime($this->page) > filemtime($in)) {
			return true; 
		}
		return false;
	}

	/**
	 * access
	 * 
	 * @return <self>
	 */
	function entry() {
		return file_get_contents($this->page);
	}

	/**
	 * put
	 * 
	 * @param string $name 
	 * @param string $value 
	 * @return <self>
	 */
	function put($name, $value) {
		$name=basename($name, 'wiki');
		return file_put_contents($this->cache.$name.".html", $value);
	}

}
