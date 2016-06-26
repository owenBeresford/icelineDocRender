<?php

namespace icelineLtd\icelineDocRenderBundle;

use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;


/**
 * PageServiceInterface 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
interface PageServiceInterface
{

	/**
	 * render
	 * 
	 * @param string $page ~ a full file path
	 * @return string, the result of rendering that
	 */
	function render($page);
	
}
