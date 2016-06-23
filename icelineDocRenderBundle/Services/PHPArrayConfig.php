<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services;

use icelineLtd\icelineLtdDocRenderBundle\ConfigInterface;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\BadFilesystemException;
use icelineLtd\icelineLtdDocRenderBundle\Exceptions\NoImplException;

/**
 * ConfigInterface 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class PHPArrayConfig implements ConfigInterface
{
	protected $hash;
	
	public function __construct($file) {
		$this->hash=[];
		$this->load($file);
	}

	/**
	 * load
	 * 
	 * @param string $file 
	 * @access public
	 * @return int ~ 0
	 * @exception Exception
	 */
	public function load($file) {{{
# don't flush current contents
# if I use eval(), i will need to change the structure of the data in the config file.
		if(!(file_exists($file) && is_readable($file))) {
			throw new BadFilesystemException("Unable to read the config file '$file'.");
		}

		try {
			$VariblesPre				=array_keys(get_defined_vars());
			require($file);
			$VariblesPost				=array_keys(get_defined_vars());
			
			foreach($VariblesPost as $k=>$v ) {
				if($v=='VariblesPre' || $v=='VariblesPost') {
					continue;
				}
				if(in_array($v, $VariblesPre)) {
					continue;	
				}
				$this->hash[$v]=$$v;
			}

		} catch(\Exception $e) {
			throw new NoImplException("Bad file '$file'. ".$e->getMessage());
		}
	}}}
	
	/**
	 * populated ~ return if this conf has anything loaded.
	 * 
	 * @access public
	 * @return void
	 */
	public function populated() {{{
		return count($this->hash) >0;
	}}}	
	
	
	/**
	 * get
	 * 
	 * @param array $qry 
	 * @return <self>
	 * @assert $obj->get(['site_settings', 'site_language']) == 'en-GB-oed'
	 * @assert $obj->get(['site_settings', 'PANDA STYLES']) == null
	 * @assert $obj->get('system_resources') == array
	 * @assert $obj->get(['system_resources', 2]) == '500'
	 * @assert $obj->get(null) == null
	 * @assert $obj->get( ['master_browser_barrier', 'uid', 'type']) == 'int'
	 * 
	 */
	public function get( $name) {
		if(is_string($name) && array_key_exists($name, $this->hash)) {
			return $this->hash[$name];
		}

# welcome to wormhole routing for inmemory structures
		if(is_array($name) ) {
			$k							= 0;
			$cur						= $this->hash;
			foreach($name as $k => $v) {
				if(array_key_exists($v, $cur)) {
					$cur				= $cur[$v];
					if(!is_array($cur)) {
# can' iterate further
						break;
					}
				} else {
					break;
				}
			}

# if they asked for 2level deep array, and got it; return it them
			if($k==count($name)-1) {
				return $cur;
			} else {
# otherwise a fat null, same as next...
				return null;
			}
		}
		return null;		
	}
	
}
