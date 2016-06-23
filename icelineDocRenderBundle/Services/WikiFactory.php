<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services; 

use icelineLtd\icelineLtdDocRenderBundle\PagesCollectionInterface;
use icelineLtd\icelineLtdDocRenderBundle\WikiFactoryInterface;
use icelineLtd\icelineLtdDocRenderBundle\ConfigInterface;

/**
 * WikiFactory 
// if I can get a solution to setup those param without messing up my other classes, I will drop this class
 * 
 * @uses WikiFactoryInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class WikiFactory implements WikiFactoryInterface
{
	protected $conf;
	protected $pages;

	function __construct() {		
		$this->conf=null;
		$this->pages=null;
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
	 * setPagesCollection
	 * 
	 * @param PagesCollectionInterface $pci 
	 * @return <self>
	 */
	function setPageCollection(PagesCollectionInterface $pci) {
		$this->pages=$pci;
		return $this;		
	}
	
	/**
	 * config_wiki ~ function to apply settings to the Wiki library
	 *
	 * This is likely to change, therefore isolated
	 *
	 * References
	 *   http://wiki.horde.org/RuleWikilink
	 *   http://pear.reversefold.com/dokuwiki/text_wiki:ruleraw
	 *   https://github.com/meisteg/wiki/blob/master/class/WikiManager.php
	 * need to add css + other styling
	 * 
	 * @todo any more rules.
	 * @assert $obj->get() == 'Text_Wiki'
	 * Doesn't have many tests, will crash if deps not supplied.  Little branching 
	 */
	public function get() {
		$wiki							= new \Text_Wiki();
		$format							= $this->conf->get(array('site_settings','wiki_render_format'));

		$url							= $this->conf->get(array('site_settings','network_protocol')).'://'.$this->conf->get(array('site_settings','site_baseurl')). $this->conf->get(array('site_settings','resource_dir'));
		$wiki->setRenderConf($format, 'freelink', 'view_url', $url );

		$pages 							= $this->pages->all($this->conf->get(array('site_settings','res_dir')));
		$wiki->setFormatConf($format, array('translate'=>HTML_SPECIALCHARS, 'charset'=>'UTF-8')); 
		$wiki->setRenderConf($format, 'freelink', 'pages', $pages);	
		$wiki->setRenderConf($format, 'freelink', 'new_url', false );

        $wiki->setRenderConf($format, 'list', 'css_ul', 'ulbasic');      
		$wiki->setRenderConf($format, 'heading', 'css_h1', 'dontend');
		$wiki->setRenderConf($format, 'heading', 'css_h2', 'dontend');
		$wiki->setRenderConf($format, 'heading', 'css_h3', 'dontend');
		$wiki->setRenderConf($format, 'heading', 'css_h4', 'dontend');
        $wiki->setRenderConf($format, 'list', 'css_ul_li', 'libasic' );  

        $wiki->setRenderConf($format, 'wikilink', 'pages', $pages);
        $wiki->setRenderConf($format, 'wikilink', 'new_url', 'http://www.google.com/q=?' );
		$url							= $this->conf->get(array('site_settings','network_protocol')).'://'.$this->conf->get(array('site_settings','site_baseurl')).$this->conf->get(array('site_settings','resource_dir'));
		$wiki->setRenderConf($format, 'wikilink', 'view_url', $url );

        $wiki->setRenderConf($format, 'url', 'css_inline', 'cleanimage'); 
        $wiki->setRenderConf($format, 'url', 'css_img', 'cleanimage');    

		$wiki->setRenderConf($format, 'code', 'css', 'codeblock'); 
		$wiki->enableRule('html');

# add more
		return $wiki;
	}
	
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
