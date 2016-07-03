<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Render;

use  icelineLtd\icelineDocRenderBundle\ConfigInterface;
use  icelineLtd\icelineDocRenderBundle\ResourceInterface ;
use  icelineLtd\icelineDocRenderBundle\TemplateRendererInterface;
use  icelineLtd\icelineDocRenderBundle\ChunkInterface;
use  icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use  icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use  icelineLtd\icelineDocRenderBundle\ChunkTransformInterface;

/**
 * TabListRenderer 
 * 
 * @uses ChunkTransformInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class TabListRenderer implements ChunkTransformInterface
{
	protected $conf;
	protected $template;
	protected $file;
	protected $format;
		
	function __construct() {
	}
		
	/**
	 * setConfig
	 * 
	 * @param ConfigInterface $c 
	 * @return <self>
	 */
	function setConfig(ConfigInterface $c) {
		$this->conf=$c;
		// import settings
		return $this;
	}
	
	/**
	 * setResourceHash
	 * 
	 * @param ResourceInterface $rh 
	 * @return <self>
	 */
	function setResourceHash(ResourceInterface $rh) {
		$this->file=$rh;
		return $this;
	}
	
	/**
	 * setFormat
	 * 
	 * @param string $in 
	 * @access public
	 * @return <self>
	 */
	public function setFormat($in) {
		$this->format=$in;
		return $this;
	}


	/**
	 * setTemplateRenderer
	 * 
	 * @param TemplateRendererInterface $tri 
	 * @return <self>
	 */
	function setTemplateRenderer(TemplateRendererInterface $tri) {
		$this->template=$tri;
		return $this;
	}
	
	/**
	 * getChunkType
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType() {
		return [ChunkInterface::TABLIST];
 	}

	/**
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @return string
	 * @assert $obj->render($in) == 'string'
	 * and add more data input
	 */
	public function render(ChunkInterface $ci) {
		$data=$ci->getData();
		
		$text=$this->makeTabList($data);
		if(!array_key_exists('first-tab', $data) || !$data['first-tab'] )  {
			throw new BadResourceException("Must set the first tab value.");
		}
		$tmp				=<<<EOJS
$(document).ready(function() {
\$ice.tab_init();
\$ice.tab_change('{$data['first-tab']}' );
})
EOJS;
		$pc=new ProgrammaticChunk("random".time(), $tmp, "js", null);
		$pc->setData($this->template->render($pc));
		$this->file->appendChunk('extraHeader', $pc);	

		return $text;
	}
	
	/**
	 * maketablist
	 * 
# data for the tab
# data for the summary if present
# data for the actual body of content
	 *
	 * @param mixed $args 
	 * @access public
	 * @return string
	 */
	function makeTabList($args) {
		$out		= "";
		$data		= array();
		$top		= "<ul class=\"tabList\">\n";

		foreach($args as $k=>$v) {
			if(!is_array($v)) {
				continue;
			}

			$tmp		= $this->file->getChunk('tab-summary');
			if(is_string($tmp)) {
				if(array_key_exists('summary-class', $v)) {
					$tmp=str_replace('[[summary-class]]', $v['summary-class'], $tmp);
				}

				if(array_key_exists('summary-id', $v)) {
					$tmp=str_replace('[[summary-id]]', $v['summary-id'], $tmp);
				}
				$data[$k]['sum'] =$tmp;
			} else {
				$sumClass="";
				if(array_key_exists('summary-class', $v)) {
					$sumClass=" class=\"".$v['summary-class']."\"";
				}
				$sumID	="";
				if(array_key_exists('summary-id', $v)) {
					$sumID=" id=\"".$v['summary-id']."\"";

				}
				$text		="[[tab-summary]]";
				if(array_key_exists('tab-summary', $v)) {
					$text	=$v['tab-summary'];
				}
				$data[$k]['sum']="<p$sumClass$sumID>$text</p>\n";
			}

			$tmp		= $this->file->getChunk('tab-body');
			if(is_string($tmp)) {
				if(array_key_exists('tab-class', $v)) {
					$tmp=str_replace('[[tab-class]]', $v['tab-class'], $tmp);
				}

				if(array_key_exists('tab-id', $v)) {
					$tmp=str_replace('[[tab-id]]', $v['tab-id'], $tmp);
				}
				$data[$k]['body'] =$tmp;
			} else {
				$sumClass="";
				if(array_key_exists('tab-class', $v)) {
					$sumClass=" class=\"".$v['tab-class']."\"";
				}
				$sumID	="";
				if(array_key_exists('tab-id', $v)) {
					$sumID=" id=\"".$v['tab-id']."\"";

				}
				$text		="[[tab-body]]";
				if(array_key_exists('tab-body', $v)) {
					$text	=$v['tab-body'];
				}
				$data[$k]['body']="<div$sumClass$sumID>$text</div>\n";
			}

			$top	.="<li id=\"".$v['button-id']."\">".$v['title']."</li>\n";
		}

		$top		.="</ul>\n";
		if(isset($args['render-local'])) {

			$out		.="<div class=\"".$args['tab-main-class']."\">\n";
			$out		.=$top;
			$out		.="<fieldset>";
			$sum		="";
			$body		="";
			foreach($data as $k=>$v) {
				$sum	.=$v['sum'];
				$body	.=$v['body'];
			}
			$out		.=$sum."\n";
			$out		.=$body."\n";
			$out		.="</fieldset>\n</div>";
			return $out;
		} else {
			return $data;
		}
	}
	
} 
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
