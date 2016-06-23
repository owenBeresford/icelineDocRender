<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Services;

use icelineLtd\icelineLtdDocRenderBundle\ResourceInterface;
 use icelineLtd\icelineLtdDocRenderBundle\ConfigInterface; 
  use icelineLtd\icelineLtdDocRenderBundle\ChunkInterface;
  use icelineLtd\icelineLtdDocRenderBundle\PagesCollectionInterface;

/**
 * StaticValuesFactory 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class StaticValuesFactory
{
	/**
	 * NAME ~ this class is shouved in the same worker has in the facade classes, under this name    
	 * 
	 * @const string
	 */
	const NAME='static-values';
	
	protected $conf;
	protected $sess;
	protected $pages;

	/**
	 * __construct
	 * 
	 * @param ConfigInterface $ci 
	 * @return <self>
	 */
	function __construct(ConfigInterface $ci) {
		$this->conf=$ci;
	}
	
	/**
	 * setSession
	 * 
	 * @param SessionInterface $si 
	 * @return <self>
	 */
	function setSession(SessionInterface $si) {
		$this->sess=$si;
		return $this;
	}

	/**
	 * setPageCollection
	 * 
	 * @param PagesCollectionInterface $pci 
	 * @return <self>
	 */
	function setPageCollection(PagesCollectionInterface $pci)  {
		$this->pages=$pci;
		return $this;
	}

	/**
	 * get
	 * 
	 * @param ResourceInterface $in 
	 * @return <self>
	 * @assert $obj->get($in) == 'icelineLtd\icelineLtdDocRenderBundle\ResourceInterface'
	 * Add more tests manually
	 */
	public function get(ResourceInterface $in) {
		$out		= $this->pages->getResource('blank');
			$e=[];
		if($this->sess) {
			$e		= $this->sess->get(['error-message']);
		}		
		$meta=$in->getChunk(ChunkInterface::PAGE_META);
		
		$names		= array(
			'sitename'  =>array('sitename', 'plain' ),
			'resourcekeywords' =>array('resourcekeywords', 'plain' ),
			'resource'	=> array('resourcename', 'plain' ),
			'lang'		=>array('resourcelang', 'plain'),
			'menulist' 	=>array('menulist', 'html'),
			'alert' 	=>array('systemalert', 'html'),
			'strapline'	=>array('strapline', 'html'),
			'title'		=>array('resourcetitle', 'html'),
			'errorlist' =>array('errorlist', 'html'),
			'author'	=>array('resourceauthor', 'plain'),
			'modifieddate'=>array('modifieddate', 'plain'),
			'rendereddate'=>array('rendereddate','plain' ),
			'extraHeader'=>array('extraHeader', 'html'),
			'desc'		=>array('resourcedescription', 'plain'),
			'site_baseurl'=>array('site_baseurl', 'plain'),
			'site_sitelink'=>array('site_sitelink', 'plain'), // need to fix the name on this./..
			'external_url'=>array('external_url', 'plain'),
							);
		
			$items 		= array(
				'sitename'	=> $this->conf->get(['site_settings', 'site_name']),
			'resourcekeywords' =>  $meta->getAttribute('keywords'),
			'lang'  	=> (null!==$meta->getAttribute('lang') )?$meta->getAttribute('lang'):$this->conf->get(array('site_settings', 'site_language')),
			'resource'	=> $in->name() ,
			'modifieddate'=>date( $this->conf->get(array('site_settings', 'human_date')), $meta->getAttribute('modified')),
			'rendereddate'=> date($this->conf->get(array('site_settings', 'human_date'))),
			'menulist'	=> "DISABLED", // see CODE_SAMPLE at end
			'alert' 	=> $this->conf->get(array('site_settings', 'system_alert')),
			'strapline' => (null!==$meta->getAttribute('strapline') )?$meta->getAttribute('strapline'):'',
			'title'		=> (null!==$meta->getAttribute('title') )?$meta->getAttribute('title'):'',
			'errorlist' => !empty($e)?implode("<br />\n", $e):'',
			'author'	=> (null!==$meta->getAttribute('author') )?$meta->getAttribute('author') : '',
			'site_baseurl'=>$this->conf->get(array('site_settings', 'network_protocol')).'://'. $this->conf->get(array('site_settings', 'site_baseurl')).$this->conf->get(array('site_settings', 'resource_dir')),
			'site_sitelink'=>$this->conf->get(array('site_settings', 'network_protocol')).'://'. $this->conf->get(array('site_settings', 'site_baseurl')).'/', 
			'external_url'=>$this->conf->get(array('site_settings', 'network_protocol')).'://'. $this->conf->get(array('site_settings', 'site_baseurl')).'/'.$this->conf->get(array('site_settings', 'external_dir')),
			'extraHeader'=>$in->getChunk('extraHeader'),
					);

		$tt				= $in->getChunk('resourcedescription');
		if($tt) {
			$items['desc']=$tt;
		} elseif(null!==$meta->getAttribute('description')) {
			$items['desc']=$meta->getAttribute('description');
		} else {
			$items['desc']=$this->conf->get(array('site_settings', 'description'));
		}

		$wrapping	= array(
			'lang'		=> "",
			'menulist'	=> '',
			'author'	=> '',
			'title'		=> '',
			'alert' 	=> "<p id=\"errorLog\">alert</p>",
			'strapline'	=> "<p>strapline</p>",
			'errorlist' => '<p>errorlist</p>',
			'sitename'  =>'',
			'resourcekeywords' =>'',
			'resource'	=> '',
			'title'		=> '',
			'modifieddate'=>'',
			'rendereddate'=> '',
			'extraHeader'=>'',
			'desc'		=>'',
			'external_url'=>'',
			'site_baseurl' =>'',
			'site_sitelink'=>'',

					);

		foreach($names as $k=>$v) {
			$cur			= $items[$k];

			if(isset($wrapping[$k]) && strlen($wrapping[$k]) && strlen($cur)) {
				$cur=str_replace($k, $cur, $wrapping[$k]);
			}
			$out->setChunkRaw($v[0], $cur, 'plain', false);		
		}
		
		$out->setChunk(ChunkInterface::PAGE_META, $in->getChunk(ChunkInterface::PAGE_META));
		// maybe others
		return $out;
	}
	
protected $CODE_SAMPLE = <<<'EOPHP'
		/**
	 * menu_island ~ create a HTML island for the menu.
	 * Seperate function as used in several places.
     * I have copied this into this class on the understanding I would need to change it...
     *
	 * @access public
	 * @return void
	 */
	function menu_island2() {{{
		$style						= array('odd'=>'h4_odd', 'ul'=>'h4_lean');
		$hhd						= $this->page->get_headings();
		$hhd						= $this->_list2links($hhd);

		$hhd						= array_merge($this->do_menu(), $hhd);
		$menu						= '';
		if(is_array($hhd)) {
			$hht					= $this->conf->get(array('site_settings', 'page_sections_header'));
			$hht					= "<a name=\"pageMenu\">$hht</a>";
			$menu					= $this->_make_ul($hhd, $style) ;
#			$menu					=$this->_make_fieldset($this->_make_ul($hhd, $style), $hht, 'h4_menu');
			$menu					.="<br />\n";
		}
		return $menu;
	}}}
	/**
	 * _list2links
	 * 
	 * @param array $titles 
	 * @access protected
	 * @return array
	 */
	protected function _list2links($titles) {{{
		$t						= array();
		if(!is_array($titles)) {
			$titles				= array($titles);
		}
		$tt						= $this->conf->get(array('site_settings','resource_dir')).basename($this->page->get_name(), '.wiki');
		foreach($titles as $k=>$v) {
			$v					= str_replace('[site-baselink]', $this->conf->get(array('site_settings','network_protocol')).'://'.$this->conf->get(array('site_settings','site_baseurl')) , $v);
			$v					= str_replace('[site-externallink]', $this->conf->get(array('site_settings','network_protocol')).'://'. $this->conf->get(array('site_settings','site_baseurl')).$this->conf->get(array('site_settings','external_dir')) , $v);
			$v					= str_replace('[site-resourcelink]', $this->conf->get(array('site_settings','network_protocol')).'://'.$this->conf->get(array('site_settings','site_baseurl')).$this->conf->get(array('site_settings','resource_dir')) , $v);

			$ibits				= explode('[[#', $v, 2);
			if(is_array($ibits) && count($ibits)>1) {
				$iname			= trim($ibits[0]);
				$iref			= trim(str_replace(']', '', $ibits[1]));
				$t[$iname]		= $tt.'#'.$iref;
				$k				= $iname;
			} else {
				$v				= strip_tags($v);
				$t[$k]			= $v;
			}
# This section of logic is on the wrong place.
# This is rasterising code, but necessary as the output is visible text.
			$nt					= trim($this->page->wiki_2_xhtml(trim($t[$k])));
# Would be nice if I knew a method not to add the surrounding p tag
			$lo					= 3; # <p>
			$hi					= -4; # </p>
			$t[$k]				= substr($nt, $lo, $hi);

		}
		return $t;
	}}}
EOPHP;

}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
