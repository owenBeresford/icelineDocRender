<?php

namespace icelineLtd\icelineDocRenderBundle\Services\Transform;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\ChunkTransformInterface;
use icelineLtd\icelineDocRenderBundle\ConfigInterface ;
use icelineLtd\icelineDocRenderBundle\Services\ResourceHash;
use icelineLtd\icelineDocRenderBundle\ChunkRendererInterface;
use icelineLtd\icelineDocRenderBundle\Exceptions\NoImplException;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineDocRenderBundle\TemplateRendererInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * TemplateRenderer 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class FilterTransform implements TemplateRendererInterface
{
	protected $log;

	/**
	 * __construct
	 * 
	 * @return <self>
	 */
	function __construct() {
		$this->log=null;
	}
	
	/**
	 * setLogger
	 * 
	 * @param LoggerInterface $l 
	 * @return <self>
	 */
	function setLogger(LoggerInterface $l) {
		$this->log=$l;
		return $this;
	}
	

	/**
	 * transform
	 * 
	 * @param ResourceInterface $in 
	 * @access public
	 * @return ResourceInterface
	 * @assert $obj->transform($in) == 'icelineLtd\icelineDocRenderBundle\ResourceInterface'
	  Just one test for the iterator
	 */
	public function transform(ResourceInterface $ri) {
		$ri->rewind();
		while($ri->valid()) {
			$t=$ri->current();
			$ri->setChunk($t->getName(), $this->render($t));
			$ri->next();
		}
	
		return $ri;
	}

	/**
	 * render
	 *
	 * @param ChunkInterface $ci 
	 * @access public
	 * @return ChunkInterface 
	 * @throws BadResourceException on unknown filter
	 * @assert $obj->render(XXX) == get_class(XXX)
	 * run for each filter option
	 */
	public function render(ChunkInterface $ci) {
		if(!ResourceHash::renderable($ci->getFormat())) {
			return $ci;
		}
		$text=$ci->getData();

		switch($ci->getFilter()) {
		case ChunkInterface::NOWRAP :
			$matches=[];
			if(preg_match('/<p>(.+)<\/p>/m', $text, $matches)) {
				$text=$matches[1];
				$ci->setData($text);
			}
			break;

		case ChunkInterface::ESCAPE :
			$ci->setData( htmlentities($text, ENT_HTML5 | ENT_NOQUOTES ));
			break;

		case ChunkInterface::ENCODE :
			$ci->setData( urlencode($text));
			break;

		case ChunkInterface::JSON :
			$ci->setData( json_encode($text, JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT));
			break;

		case null:
		case '': // its not required to have a filter
			break;

		default:
			throw new BadResourceException("Unknown filter ".$ci->getFilter()." on chunk ".$ci->getName());
		}
		return $ci;
	}

}	
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
