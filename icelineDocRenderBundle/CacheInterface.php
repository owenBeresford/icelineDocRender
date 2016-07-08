<?php

namespace icelineLtd\icelineDocRenderBundle;

/**
 * CacheInterface 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
interface CacheInterface
{

	function hit($name);

	function entry();

	function put($name, $value);
} 

