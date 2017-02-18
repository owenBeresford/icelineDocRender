<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Render;

use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use icelineLtd\icelineDocRenderBundle\Services\HTMLise;
use icelineLtd\icelineDocRenderBundle\ChunkInterface;
 use icelineLtd\icelineDocRenderBundle\ChunkTransformInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface  ;


/**
 * FormRenderer 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class FormRenderer implements ChunkTransformInterface
{
	protected $conf;
	protected $htmlise; 
	protected $format;
	protected $sess;	

	function __construct() {
		$this->sess=null;
		$this->conf=null;
		$this->format='form';
		$this->htmlise=null;
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
	 * setHTMLise
	 * 
	 * @param HTMLise $h 
	 * @return <self>
	 */
	function setHTMLise(HTMLise $h) {
		$this->htmlise=$h;
		$this->htmlise->setConfig($this->conf);
		return $this;
	}
	
	/**
	 * getChunkType
	 * 
	 * @static
	 * @return string
	 */
	public static function getChunkType():array {
		return [ChunkInterface::FORM];
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
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @return string
	 * @assert $obj->render($in) == 'string'	
	 * duplicate for several forms
	 */
	public function render(ChunkInterface $ci):string {
		$data=$ci->getData();
		$display			= $this->conf->get(array('site_settings', 'form-strings'));
		$style				= array( 'formlabel'=>'h4_label');		
		$this->htmlise->setStyles($style);
		$html2=clone $this->htmlise;
		
		$str	= $items = [];
		foreach($data as $k=>$v) {
			if(is_string($k)) {
				$str[$k]	= $v;
			} else {
				$items[$k]	= $v;
			}
		}
		if(!array_key_exists('wrappers', $str)) {
			$str['wrappers']= false;
		}		
		if(isset($data['protect-csrf'])) {		
			$this->generateCSRF($items);
			unset($data['protect-csrf']);			
		}
		$post=$this->getPreviousPost();
		$html2->make_form_items($items, $post, $str['wrappers']);
		$this->htmlise->push_form($str);
		$this->htmlise->render_stack($html2->get_buffer());

		return $this->htmlise->get_buffer();		
	}

	/**
	 * generateCSRF
	 * 
	 * @param array $items MODIFIED
	 * @return void
	 */
	function generateCSRF(array &$items) {
		$tt				= $this->sess->get("forms.$name.csrf.key" );
		$key			= null;
		if(	$tt ==null) { 
	
			$key		= $this->sess->cycle_id(false);
			$this->sess->set("forms.$name.csrf.key", $key);
			$this->sess->set("forms.$name.csrf.form", $chunk );
			$this->sess->set("forms.$name.csrf.expire", time() + intval($this->conf->get(array('site_settings', 'max_post_wait'))) );
			# this is the chunk name.
			$this->sess->set("forms.$name.csrf.form", $name);
		} else {
			$key		= $tt['key'];
		}
		# if we have the block already, dont bother to rebuild, a single resource render can't take that long
		# if we are doing multiple GETS without a POST, fine but leave the original value
		$items[]			= array(
			'value' 	=> $key,
			'type'		=> 'hidden',
			'id'		=> 'new-'.$this->conf->get(array('site_settings', 'session_name')),
								); 
	}

	/**
	 * getPreviousPost
	 * 
	 * @return array of data
	 */
	function getPreviousPost() {
		$post				=[];
		if($this->sess && $this->sess->get("forms.$name.submission" )) {
			$post			= $this->sess->get("forms.$name.submission");
		}
		return $post;		
	}
	
} 
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php

