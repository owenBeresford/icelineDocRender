<?php

namespace icelineLtd\icelineDocRenderBundle;

/**
 * ConfigInterface 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
interface ConfigInterface
{

	/**
	 * get
	 * 
	 * @param array $qry 
	 * @return <mixed>
	 */
	function get( $qry);

	/**
	 * populated
	 * 
	 * @access public
	 * @return bool
	 */
	function populated():bool;	
}
