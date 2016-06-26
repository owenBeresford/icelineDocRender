<?php

namespace icelineLtd\icelineDocRenderBundle;

use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\ChunkTransformInterface;

/**
 * TemplateRenderer 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
interface TemplateRendererInterface
{

	/**
	 * transform
	 * 
	 * @param ResourceInterface $ri 
	 * @access public
	 * @return <self>
	 */
	function transform(ResourceInterface $ri);
	
	/**
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @access public
	 * @return <self>
	 */
	function render(ChunkInterface $ci);
	
}
