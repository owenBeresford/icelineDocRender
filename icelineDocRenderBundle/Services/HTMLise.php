<?php
/**
 *  lib/HTMLise.php
 * 
 * Copyright (c) 2013 Owen Beresford, All rights reserved.
 * I have not signed a total rights contract, my employer isn't relevant.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 * 
 */
namespace icelineLtd\icelineDocRenderBundle\Services;

use icelineLtd\icelineDocRenderBundle\ConfigInterface;

/**
 * ******** This class is a quick hack. **********
 * Class more for internal use on documentation.
 *
 * Does not write anything to the log or other classes, no external deps.
 * I need a better mechanism for the templating, but on first use, it
 *    uses a static template inside the same class. 
 * This class makes absolutely no use of Exceptions.
 *
 * UPDATE 2013
 *  I added a few new functions, these need to sourcedata from somewhere, 
 *		so the config file it is.
 *
 * Build 1 of this is 2008 code...its a quick hack, but too usefull to discard
 * build 2 of this is 2011 code, its a bigger quick hack & too valuable 
 *
 * @author: Owen Beresford owencanprogam@fastmail.fm
 * @date: 2012-01-23
 * @version: 0.0.1
 * @package: iceline::misc
 * @licence; lGPL, see www.gnu.org/copyleft/lesser.html 
 *
 */
class HTMLise
{
	protected $conf;
	protected $buf;
	protected $style;
	protected $toc;
	protected $tocCount;
	
	protected $footer;
	protected $doctitle;
	protected $stack;
	protected $colspan;

	const TOC_MARKER					='QWERTYUIOPASDFGHJKL';

	/**
	 * Create the object, this coment is for the args....
	 * 
	 * @param $style - a hash of strings, the list of style points, and CSS class which should be applied at each.
	 * @param $strings - a hash of strings that should be applied in the 'header', 'footer', and control of the 'toc'.
	 * 
 	 * The header is currently only usd for the title element.
	 * To make it easier to reload the  TOC is disabled by default.
	 *
	 * See list of possible CSS classes here... 
	 */  
	public function __construct($style, $strings) {{{
		$this->style					=$style;
		if(array_key_exists('footer', $strings)) {
			$this->footer				=$strings['footer'];
		}
		if(array_key_exists('header', $strings)) {
			$this->doctitle				=$strings['header'];
		}
		if(array_key_exists('colspan', $strings)) {
			$this->colspan				=$strings['colspan'];
		} else {
			$this->colspan				= array();
		}
		if(array_key_exists('toc', $strings)) {
			$this->toc					=array();
			$this->tocCount				=1;
		} else {
			$this->toc					=null;
			$this->tocCount				=0;
		}

		if(class_exists('Config', false)) {
# only used in select dropdowns
			$this->conf					= Config::access();
		} else {
			$this->conf					= null;
		}
		$this->stack					= array(array(), array());
	}}}

	public function setStyles(array $in) {
		$this->style=$in;
		$this->buf='';
	}

	public function setConfig(ConfigInterface $ci) {
		$this->conf=$ci;
		return $this;
	}

	/**
	 * get_buffer ~
	 * 
	 * Only to be used for temp objects. where you dont want an entire document.
	 *
	 * @access public
	 * @return string
	 */
	public function get_buffer() {{{
		return $this->buf;
	}}}

	/**
	 * make_table ~ Render a PHP array as a HTML4 table.  
	 *	HTML.
	 *
	 * @param array of string hashes $data.  ie the first index is for rows, and is an int. the second index is a recordset normally and is a string. 
	 * @param the contents for the title row $titles
	 *    - FALSE - I don't want one. 
	 *    - array of strings - the text items to go into the HTML titles.
	 * @param string $id ~ HTML element id to apply to the table tag.
	 * @return a HTML island of the taburised data.
	 */
 	public function make_table($data, $titles, $id='') {{{
		$out							='';
		$tClass							= array_key_exists('table', $this->style)	? ' class="'.$this->style['table'].'"'	: '';

		$trClass						= array_key_exists('table-tr', $this->style) 	? $this->style['table-tr'] 				: '';
		$tdClass						= array_key_exists('table-td', $this->style) 	? $this->style['table-td'] 				: '';
		$thClass						= array_key_exists('table-th', $this->style) 	? $this->style['table-th'] 				: '';
		$thrClass						= array_key_exists('table-thr', $this->style) 	? ' class="'.$this->style['table-thr'].'"' : '';

		$thClasses						= array_key_exists('thead-thr', $this->style) ? $this->style['thead-thr'] 				: array();
		$tdClasses						= array_key_exists('thead-td', $this->style) ? $this->style['thead-td'] 				: array();
		$idi							= '';
		if($id) {
			$idi						= " id=\"$id\"";
		}
		$out							.="<table$tClass$idi>";
		$colCount						= 0;
		if($titles!==false) {
			$out						.="<thead><tr$thrClass>";
			foreach($titles as $k=>$v) {
				$curTH					= array_key_exists($colCount, $thClasses) ? ' class="'.trim($thClasses[$colCount].' '.$thClass).'"' : ' class="'.$thClass.'"';
				$out					.="<th$curTH>$v</th>";
				$colCount++;
			}
			$out						.="</tr></thead>\n";
		}

		if(count($data) == 0) {
			$out						.= '<tr class="'.$trClass.'"><td colspan="'.$colCount.'" class="'.trim('center '.$tdClass).'">No data to display.</td></tr>';
		}
		$maxCount						= 0;
		foreach($data as $k=>$v) {
			if(count($v)>$maxCount) {
				$maxCount				= count($v);
			}
		}

		$blahOdd						= 'odd';
		$blahEven						= 'even';
		if(array_key_exists('odd', $this->style)) {
			$blahOdd					= $this->style['odd'];
		}
		if(array_key_exists('even', $this->style)) {
			$blahEven					= $this->style['even'];
		}

		$rowCount						= 0;
		foreach($data as $k=>$v) {
			if(!is_int($k)) {
				continue;
			}

			if(array_key_exists('want-stripe', $this->style)) {
				$ScurRow				= $rowCount % 2 == 0 ? ' class="'.trim($blahOdd.' '.$trClass).'"' : ' class="'.trim($blahEven.' '.$trClass).'"';
			} else {
				$ScurRow				='';
			}
			$out						.="<tr$ScurRow>";
			$colCount					= 0;
			$intK						= 0;
			$col						= 0;

			foreach($v as $k2=>$v2) {

				$ScurCell					= array_key_exists($colCount, $tdClasses) ? ' class="'.trim($tdClasses[$colCount].' '.$tdClass).'"' : ' class="'.$tdClass.'"';
				if($col==0) {
					$col				= $this->_isColspan($intK, $k, $maxCount);
					if(is_int($col) && $col>0) {
						$out			.="<td$ScurCell colspan=\"$col\">$v2</td>";
					} else {
						$out			.="<td$ScurCell>$v2</td>";
					}
				} else {
					$col--;
					if($col==0) {
						$col			= $this->_isColspan($intK, $k, $maxCount);
						if(is_int($col) && $col>0) {
							$out		.="<td$ScurCell colspan=\"$col\">$v2</td>";
						} else {
							$out		.="<td$ScurCell>$v2</td>";
						}	
					} # else if >0, skip, colspan has eaten it.
				}

				$colCount++;
				$intK++;
			}
			$out						.="</tr>\n";
			$rowCount++;
		}
		$out							.="</table>\n";
		$this->buf						.=$out;
		return 0;
	}}}

	/**
	 * _isColspan
	 * 
	 * @param string $x 
	 * @param string $y 
	 * @param string $max 
	 * @access private
	 * @return 0
	 */
	private function _isColspan($x, $y, $max) {{{
		foreach($this->colspan as $k=>$v) {
			if($v[0]==$x && $v[1]==$y) {
				if($v[2]==0) {
					return $max;	
				} else {
					return $v[2];
				}
			}
		}
		return 0;
	}}}

	/**
	 * make_pre
	 * 
	 * @param mixed $data 
	 * @access public
	 * @return 0
	 */
	public function make_pre($data) {{{
		$this->buf						.="<pre>$data\n</pre>\n";
		return 0;
	}}}

	/**
	 * make_header
	 * 
	 * this is to be updated....

	 * @param string $text 
	 * @param int $strength default=2
	 * @access public
	 * @return 0
	 */
	public function make_header($text, $strength=2) {{{
		if($strength<=2 && $this->tocCount>0) {
			$this->tocCount++;
			$this->toc['#toc'.$this->tocCount]=$text;
		}
		$toc							='';
		if($this->toc) {
			$toc						= '<a class="jump" href="#toc">/\</a>';
		}

		if(array_key_exists("h$strength", $this->style)) {
			$this->buf					.= "<h$strength class=\"".$this->style["h$strength"];
			if($strength<=2) {
				$this->buf				.="\"><a name=\"#toc".$this->tocCount."\">$text</a> $toc</h$strength>\n";
			} else {
				$this->buf				.="\">$text $toc</h$strength>\n";	
			}

		} else {
			if($strength<=2 && $this->tocCount>0) {
				$this->buf				.= "<h$strength><a name=\"toc".$this->tocCount."\">";
				$this->buf				.= "$text</a> $toc</h$strength>  \n";
			} else {
				$this->buf				.= "<h$strength>$text $toc</h$strength>  \n";
			}
		}
		return 0;
	}}}

	/**
	 * Internal function to generate lists.
	 * This code here needs to be replaced, same as the Table generator.
	 *  
	 * @param hash of strings $items, the data to convert into the list.
	 * @param string $tag the type of list you are making, expect 'ul', 'ol' or 'dl'.
	 * @param hash of strings $style - a map of "position" to CSS class name, for the CSS to be applied to this list.
	 * @return the generated HTML string.	
	 *  
	 * Array keys for each row:
	 *  - key
	 *  - value
	 *  - dtid
	 *  - ddid
	 *  - class
	 * 
	 * Style tags
	 *  - dl
	 *  - even 
	 *  - odd
	 *  - dt
	 *
	 * @param array $items
	 * @param string $id
	 * @access private
	 * @return 0
	 */
	private function make_DLlist($items, $id=null) {{{
		$tag							='dl';
		$str							='';
		if( array_key_exists($tag, $this->style )) {
			$str						= "<$tag class=\"".$this->style[$tag];
			if($id) {
				$str					.="\" id=\"$id\">\n";
			} elseif(array_key_exists('id', $items)) {
				$str					.="\" id=\"".$items['id']."\">\n";
			} else {
				$str					.="\">\n";
			}
		} else {
			$str						= "<$tag";
			if($id) {
				$str					.=" id=\"$id\">\n";
			} else {
				$str					.=">\n";
			}
		}

		$flipflop						= false;
		foreach($items as $k=>$v) {

			$str						.= "<dt ";
			$str 						.= 'class="';

			if( array_key_exists('even', $this->style ) && $flipflop)  {
				$str 					.= $this->style['even'].' ';	
			} 
			if(array_key_exists('odd', $this->style ) && !$flipflop)  {
				$str 					.= $this->style['odd'].' ';	
			}
			if( array_key_exists('dt', $this->style ) )  {
				$str 					.= $this->style['dt'].' ';	
			}
			if(is_array($v) && array_key_exists('class', $v)) {
				$str 					.= $v['class'].' ';
			}
			if(is_array($v) && array_key_exists('dtid', $v)) {
				$str 					.= $v['dtid'].' ';
			}
			$str	 					= trim($str).'">';
			$str						.=$k;
			$str						.="</dt>";

			$str						.= "<dd ";
			$str 						.= 'class="';

			if( array_key_exists('even', $this->style ) && $flipflop)  {
				$str 					.= $this->style['even'].' ';	
			} 
			if(array_key_exists('odd', $this->style ) && !$flipflop)  {
				$str 					.= $this->style['odd'].' ';	
			}
			if(array_key_exists('dd', $this->style ) )  {
				$str 					.= $this->style['dd'].' ';	
			}
			if(is_array($v) && array_key_exists('class', $v)) {
				$str 					.= $v['class'].' ';
			}
			if(is_array($v) && array_key_exists('dtid', $v)) {
				$str 					.= $v['dtid'].' ';
			}
			$str	 					= trim($str).'">';
			if(is_array($v)) {
				$str					.=$v['value'];
			} else {
				$str					.= $v;
			}
			$str						.="</dd>\n";

			$flipflop					= !$flipflop;
		}

		$str							.= "</$tag><br class=\"fix0r\"/>\n";
		$this->buf						.=$str;
		return 0;
	}}}

	/**
	 * make_list
	 * 
	 * @param array $items 
	 * @param string $tag  enum('dl', 'ol', 'ul')
	 * @param string $id 
	 * @access public
	 * @return 0
	 */
	public function make_list($items, $tag, $id=null) {{{
		if($tag=='dl') {
			return $this->make_DLlist($items, $id);
		}

		$str							='';
		$tag							=strtolower($tag);
		if($this->style && array_key_exists($tag, $this->style )) {
			$str						= "<$tag class=\"".$this->style[$tag];
			if($id) {
				$str					.="\" id=\"$id\">\n";
			} elseif(array_key_exists('id', $items)) {
				$str					.="\" id=\"".$items['id']."\">\n";
			} else {
				$str					.="\">\n";
			}
		} else {
			$str						= "<$tag";
			if($id) {
				$str					.=" id=\"$id\">\n";
			} else {
				$str					.=">\n";
			}
		}

		$flipflop						= false;
		foreach($items as $k=>$v) {
			if(is_string($k)) {
				continue;
			}
			$str						.= "<li ";
			$str 						.= 'class="';

			if($this->style && array_key_exists('even', $this->style ) && $flipflop)  {
				$str 					.= $this->style['even'].' ';	
			} 
			if($this->style && array_key_exists('odd', $this->style ) && !$flipflop)  {
				$str 					.= $this->style['odd'].' ';	
			}
			if($this->style && array_key_exists('li', $this->style ) )  {
				$str 					.= $this->style['li'].' ';	
			}
			if(is_array($v) && array_key_exists('class', $v)) {
				$str 					.= $v['class'].' ';
			}
			$str	 					= trim($str).'">';	
			if(!is_array($v)) {
				$str					.=$v;

			} else {
				if(array_key_exists('href', $v)) {
					$str				.="<a href=\"".$v['href']."\"";
					if(array_key_exists('next', $v)) {
						$str			.=" next=\"".$v['next']."\"";
					}
					if(array_key_exists('id', $v)) {
						$str			.=" id=\"".$v['id']."\"";
					}
					if(array_key_exists('aclass', $v)) {
						$str 			.= ' class="'.$v['aclass'].'"';
					}
					$str				.=">";
				}
				$str					.=$v['display'];
				if(array_key_exists('href', $v)) {
					$str				.="</a>";
				}
			}

			$str						.="</li>\n";				
			$flipflop					= !$flipflop;
		}

		$str							.= "</$tag>\n";
		$this->buf						.=$str;
		return 0;
	}}}

	/**
	 * make_toc
	 *
	 * Technically create a marker
	 * 
	 * @access public
	 * @return 0
	 */
	public function make_toc() {{{
		$this->buf						.= htmlise::TOC_MARKER;
		return 0;
	}}}

	/**
	 * push_form
	 * 
 	 * Array of this to set in the form tag.
	 * ['method', 'encoding', 'action', 'name']
	 *
	 * I have omitted the DOM style JS event mounting points, as I 
	 * dislike the lack of precision between strings (as HTML) and 
	 * function pointers (as JS).  
	 * Due to widespread adoption of jQuery, this is old anyway.
	 *
	 * @param mixed $opts 
	 * @access public
	 * @return true
	 */
	public function push_form($opts) {{{
		if(!array_key_exists('name', $opts)) {
			$opts['name']				= $opts['id'];
		}
		if(array_key_exists('action', $opts) && $opts['action']) {
# This switches is to control rendering  
# if the render option is past, 'original' will be assigned.
			if(property_exists($this, 'switches') && 
				array_key_exists('original', $this->switches) &&
				$this->switches['original']) {
				if(strpos($opts['action'], '?')) {
					$opts['action'].='&render='.$this->switches['original'];
				} else {
					$opts['action'].='?render='.$this->switches['original'];
				}
			}
		}

		$names							= array('method', 'enctype', 'encoding', 'action', 'name', 'id');
		$open							="<form";
		foreach($names as $v) {
			if(array_key_exists($v, $opts)) {
				$open					.=" $v=\"".$opts[$v]."\"";
			}
		}
		$open							.=">";
		$this->stack[0][]				= $open;

		$this->stack[1][]				= '</form>';
		return 0;
	}}}

	/**
	 * return_a
	 * 
	 * Probably ought to add CSS class support.
	 *
	 * @param string $url 
	 * @param string $name 
	 * @param string $title 
	 * @param string $id 
	 * @access public
	 * @return 0
	 */
	public function return_a($url, $name, $title=false, $id=false ) {{{
		if($title) {
			if($id) {
				return "<a href=\"$url\" id=\"$id\" title=\"$title\">$name</a>";
			} else {
				return "<a href=\"$url\" title=\"$title\">$name</a>";
			}

		} else {
			if($id) {
				return "<a href=\"$url\" id=\"$id\" >$name</a>";
			} else {
				return "<a href=\"$url\" >$name</a>";
			}
		}
		return 0;
	}}}

	/**
	 * make_p
	 * 
	 * @param string $text 
	 * @param string $class 
	 * @access public
	 * @return 0
	 */
	public function make_p($text, $class=false) {{{
		if($class && array_key_exists($class, $this->style)) {
			$this->buf					.="<p class=\"".$this->style[$class]."\">$text</p>";
		} elseif($class) {
			$this->buf					.="<p class=\"$class\">$text</p>";

		} else {
			$this->buf					.="<p>$text</p>";
		}
		return 0;
	}}}

	/**
	 * add_raw
	 * 
	 * @param string $t 
	 * @access public
	 * @return 0
	 */
	public function add_raw($t) {{{
		$this->buf						.=$t;
		return 0;
	}}}

	/**
	 * push_stack
	 * 
	 * @param string $open 
	 * @param string $close 
	 * @access public
	 * @return 0
	 */
	public function push_stack($open, $close=false) {{{
		$this->stack[0][]				= $open;
		if($close) {
			$this->stack[1][]			= $close;
		} else {
			$match						= array();
			$t							= preg_match('/^<([a-zA-Z]+)[ \/>]/', $open, $match);
			$this->stack[1][]			= '</'.$match[1].'>';
		}
		return 0;
	}}}

	/**
	 * wipe
	 * 
	 * @access public
	 * @return 0
	 */
	public function wipe() {{{
		$this->buf						= '';
		return 0;
	}}}

	/**
	 * render_stack
	 * 
	 * @param mixed $centre 
	 * @access public
	 * @return 0
	 */
	public function render_stack($centre) {{{
		$t1								=array_merge($this->stack[0], array($centre), array_reverse($this->stack[1], false));
		$t2								=implode("\n", $t1);
		$this->buf						.=$t2;
		$this->stack					=array(array(), array());
		return 0;
	}}}

	/**
	 * make_form_items
	 * 
Structure:
	- value ~ maybe an array for selects, radio or checkbox 
	- name
	- type
	- id
	- display
	- style ~ optional
	- optgroup ~ optional
    - style

This is a fast hack, currently no support for :
	- radio,
	- select,
	- checkbox,
	- grouping,
 	- fileupload,
	- ajax triggers,

HTML ids:
	- the form items will have the supplied $id
	- all p (when requested) will be $id.'Wrapper'
 	- all label will be $id.'Label'

Currently used style lookups
	- 'formp'
	- 'label'
	- 'formtext'
	- 'formtextarea'
	- 'formbuttons'

Add styles support properly.
Add formName prefix to id elements &maybe form items

	 * @param mixed $items 
	 * @param mixed $data 
	 * @param mixed $wrappers 
	 * @access public
	 * @return array of HTML elements OR unified into a HTML island
	 */
	public function make_form_items($items, $data, $wrappers=true) {{{
		$out						= '';
		$bits						= $this->_items($items, $data);
		if($wrappers) {
			foreach($items as $k=>$v) {
				$pclass				= '';
				if(array_key_exists('formp', $this->style)) {
					$pclass			= $this->style['formp'];
				}
				if($v['type']!='hidden') {
					$out			.= '<p id="'.$v['id'].'Wrapper" class="'.$pclass.'">';
				}
				$out				.= $bits[$k][0];
				$out				.= $bits[$k][1];
				if($v['type']!='hidden') {
					$out			.= "</p>\n";
				}
			}
			$this->buf				.= $out;
			return $out;
			
		} else {
			return $bits;
		}
	}}}

	/**
	 * _items
	 *
	 * @param mixed $items 
	 * @param mixed $data 
	 * @param mixed $wrappers 
	 * @access private
	 * @return array of HTML elements OR unified into a HTML island
	 */
	private function _items($items, $data) {{{ 
		$out						= array();
		foreach($items as $k=>$v) {
			$l						= '';
			if(array_key_exists('formlabel', $this->style)) {
				$l					= $this->style['formlabel'];
			} 
			$i						= $v['id'];

			$t						='';
			$t1						='';
			$t2						='';
			if(array_key_exists('display', $v)) {
				$t					= $v['display'].' :';
				$t1					= <<<EOHTML
<label for="$i" id="{$i}Label" class="$l">$t</label>
EOHTML;
			}
			$val					='';
			if(!array_key_exists('name', $v) ) {
				$v['name']			= $v['id'];
			}
			if(array_key_exists($v['name'], $data)) {
				$val				= $data[ $v['name']];
			}

			switch($v['type'] ) {
			case 'datetime':
				if(empty($val)) {
					$val			= date('d-m-Y h:iA');
				}
				$t1					= <<<EOHTML
<label for="{$i}_date" id="{$i}Label" class="$l">$t</label>
EOHTML;
				$t2					= $this->_datetime_input($v, $val);
				break;

			case 'text':
			case 'email':
				$t2					= $this->_text_input($v, $val);
				break;
			
			case 'textarea':
				$t2					= $this->_textarea_input($v, $val);
				break;

			case 'button':
			case 'submit':
				$t1					= '';
				$t2					= $this->_button_input($v, $val);
				break;

			case 'radio':
			case 'checkbox':
				if(array_key_exists('value', $v) && is_array($v['value'])) {
					$val			= $v['value'];
				}

				$t2					= $this->_tick_input($v, $val);
				break;

			case 'select':
				if(array_key_exists('value', $v) && is_array($v['value'])) {
					$val			= $v['value'];
				}
				$t2					= $this->_select_input($v, $val);
				break;

			case 'hidden':
				$t1					= '';
				$t2					= $this->_hidden_input($v, $val);
				break;
			}

			$out[$k]				= array($t1, $t2);
		}
		return $out;
	}}}

	/**
	 * _tick_input
	 *
	 * @param mixed $v
	 * @param mixed $value 
	 * @access private
	 * @return string of HTML
	 */
	private function _tick_input($v, $value) {{{
		$t						= $v['type'];
		$i						= $v['id'];
		if(array_key_exists('name', $v)) {
			$n					= $v['name'];
		} else {
			$n					= $v['id'];
		}
		$l						= '';
		if(array_key_exists( 'form'.$v['type'], $this->style)) {
			$l					= $this->style['form'.$v['type']];
		} elseif(array_key_exists('class', $v)) {
			$l					= $v['class'];
		}
		
		$str					= '';
		if(array_key_exists('optgroup', $v)) {
			$str				.='<optgroup id="optgroup'.$i.'"> ';
		}
		foreach($value as $kk=>$vv) {
			$str				.='<input type="'.$t.'" name="'.$i.$vv.'" id="'.$i.$vv.'" class="'.$l.'" value="'.$kk.'" />';
		}

		if(array_key_exists('optgroup', $v)) {
			$str				.='</optgroup>';
		}
		return $str;
	}}}

	/**
	 * _text_input
	 *
	 * @param mixed $v
	 * @param mixed $value 
	 * @access private
	 * @return string of HTML
	 */
	private function _text_input($v, $value) {{{
		$t						= $v['type'];
		$i						= $v['id'];
		if(array_key_exists('name', $v)) {
			$n					= $v['name'];
		} else {
			$n					= $v['id'];
		}
		$l						= '';
		if(array_key_exists( 'form'.$v['type'], $this->style)) {
			$l					= $this->style['form'.$v['type']];
		} elseif(array_key_exists('class', $v)) {
			$l					= $v['class'];
		}
		$ph						='';
		if(array_key_exists('placeholder', $v)) {
			$ph					= " placeholder=\"".$v['placeholder']."\"";
		}

		return					 <<<EOHTML
<input type="$t" name="$n" id="$i" value="$value"$ph class="$l" />
EOHTML;
	}}}

	/** 
	 * _datetime_input
	 *
	 * @param mixed $v
	 * @param mixed $value 
	 * @access private
	 * @return string of HTML
	 */
	private function _datetime_input($v, $value) {{{ 
		$i						= $v['id'];
		if(array_key_exists('name', $v)) {
			$n					= $v['name'];
		} else {
			$n					= $v['id'];
		}
		$l						= '';
		if(array_key_exists( 'form'.$v['type'], $this->style)) {
			$l					= $this->style['form'.$v['type']];
		} elseif(array_key_exists('class', $v)) {
			$l					= $v['class'];
		}
		if(is_int($value)) {
			$dt					= date('d-m-Y', $value);
			$tm					= date('H:i', $value);

		} else {
			$value				= explode(' ', $value);
			$dt					= $value[0]	;
			$tm					= $value[1]	;
		}

		return					 <<<EOHTML
<input type="text" name="{$n}_date" id="{$i}_date" value="$dt" class="{$l} JDIdate" size="10" /> <input type="text" name="{$n}_time" id="{$i}_time" value="$tm" class="{$l} JDItime" size="7" /> 
EOHTML;
	}}}

	/** 
	 * _hidden_input
	 *
	 * @param mixed $v
	 * @param mixed $value 
	 * @access private
	 * @return string of HTML
	 */
	private function _hidden_input($v, $value) {{{ 
		$t						= $v['type'];
		$i						= $v['id'];
		if(array_key_exists('name', $v)) {
			$n					= $v['name'];
		} else {
			$n					= $v['id'];
		}

		if(!isset($value) || $value=='') {
			$value				= $v['value']; # this uses the form def on purpose...
		}
		return					 <<<EOHTML
<input type="hidden" name="$n" id="$i" value="$value" />
EOHTML;
	}}} 

	/** 
	 * _button_input
	 *
	 * @param mixed $v
	 * @param mixed $value 
	 * @access private
	 * @return string of HTML
	 */
	private function _button_input($v, $value) {{{ 
		$t						= $v['type'];
		$i						= $v['id'];
		if(array_key_exists('name', $v)) {
			$n					= $v['name'];
		} else {
			$n					= $v['id'];
		}

		$value					= $v['value']; # this uses the form def on purpose...
		$l						= '';
		if(array_key_exists( 'form'.$v['type'], $this->style)) {
			$l					= $this->style['form'.$v['type']];
		} elseif(array_key_exists('class', $v)) {
			$l					= $v['class']; 
		}
		return					 <<<EOHTML
<input type="$t" name="$n" id="$i" value="$value" class="$l" />
EOHTML;
	}}} 

	/** 
	 * _select_select
	 *
	 * @param mixed $v
	 * @param mixed $value 
	 * @access private
	 * @return string of HTML
	 */
	private function _select_input($v, $value) {{{ 
		$t						= $v['type'];
		$i						= $v['id'];
		if(array_key_exists('name', $v)) {
			$n					= $v['name'];
		} else {
			$n					= $v['id'];
		}
		if(is_string($value)) {
			if(is_object($this->conf) && $this->conf->get($value)) {
				$value			= $this->conf->get($value);
			} elseif(array_key_exists( $value, $_GLOBALS) ) {
				$value			= $_GLOBALS[$value];
			}
		}
		$selected				= false;
		if(isset($v['selected'])) {
			$selected			= $v['selected'];
		}
 
		$valtext				= '';
// no optgroups at present
		foreach($value as $kk=>$vv) {
			if($selected===$vv) {
				$valtext		.='<option selected="selected" value="'.$vv.'">'.$kk.'</option>';
			} else {
				$valtext		.='<option value="'.$vv.'">'.$kk.'</option>';
			}
		}

		$l						= '';
		if(array_key_exists( 'form'.$v['type'], $this->style)) {
			$l					= $this->style['form'.$v['type']];
		} elseif(array_key_exists('class', $v)) {
			$l					= $v['class']; 
		}
		return					 <<<EOHTML
<select name="$n" id="$i" class="$l" >
$valtext
</select>
EOHTML;
	}}} 

	/** 
	 * _textarea_input
	 *
	 * @param mixed $v
	 * @param mixed $value 
	 * @access private
	 * @return string of HTML
	 */
	private function _textarea_input($v, $value) {{{
		$i						= $v['id'];
		if(array_key_exists('name', $v)) {
			$n					= $v['name'];
		} else {
			$n					= $v['id'];
		}

		$va						= $v['value'];
		$l						= '';
		$rw						='';
		$cl						='';
		$ph						='';
		if(array_key_exists( 'form'.$v['type'], $this->style)) {
			$l					= $this->style['form'.$v['type']];
		} elseif(array_key_exists('class', $v)) {
			$l					= $v['class'];
		}
		if(array_key_exists('rows', $v)) {
			$rw					= "rows=\"".$v['rows']."\" ";
		}
		if(array_key_exists('cols', $v)) {
			$cl					= "cols=\"".$v['cols']."\" ";
		}
		if(array_key_exists('placeholder', $v)) {
			$ph					= "placeholder=\"".$v['placeholder']."\" ";
		}

		return					 <<<EOHTML
<textarea name="$n" id="$i" class="$l" $ph$rw$cl>$value</textarea>
EOHTML;
	}}}

	/** 
	 * make_html_doc
	 *
	 * @param mixed $head
	 * @param mixed $body
	 * @param mixed $footer
	 * @access protected
	 * @return string of HTML
	 */
# cached ::
# <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
# <!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
# <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
# <html lang="en" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
	function make_html_doc($head, $body, $footer ) {{{
		$time							= date('d/m/Y');
		return                          <<<EOPAGE
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en_UK" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
$head
</head>
<body id="body">
$body
<div id="footer">
<p>$footer</p>
</div>
</body>
</html>
EOPAGE;
	}}}

	/** 
	 * make_html_headers
	 *
	 * @param mixed $title
	 * @access protected
	 * @return string of HTML
	 */
	function make_html_headers($title) {{{
		$generator					= "iceline productions.";

		$str						= <<<EOHEADERS
<title>$title</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="en_UK" />
<meta name="Generator" content="$generator" />
<link href="./docs.css" rel="stylesheet" type="text/css" media="all" />

EOHEADERS;
		return $str;
	}}}

	/** 
	 * render ~ convert to a string
 	 * 
	 * This emptys the internal buffers, and build any TOC.
	 * Maybe rename this to __toString()
	 *
	 * @access protected
	 * @return string of HTML
	 */
	public function render( ) {{{
		$t				= $this->make_html_headers( $this->doctitle);
		$t2				= $this->buf;

		if($this->toc) {
			$this->buf	='';
			$t3			= array();
			foreach($this->toc as $k=>$v ) {
				$t3[]	=$this->return_a($k, $v, "Jump to the $v section" );
			} 

			$this->buf	='<a name="toc"></a>';
			$this->make_list($t3, 'ul', 'toclist');
			$this->buf	.="<br />";
			$this->buf	.="<br />";
			$t2			= str_replace( HTMLise::TOC_MARKER, $this->buf, $t2); 
		}
		$html			= $this->make_html_doc($t, $t2, $this->footer );
		$this->buf		= '';
		return $html;
	}}}

# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
}
