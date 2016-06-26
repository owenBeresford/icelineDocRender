<?php

namespace icelineLtd\icelineDocRenderBundle;

/**
 * PagesCollectionInterface 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
interface PagesCollectionInterface
{

	/**
	 * all ~ lists all files
	 * 
	 * @return array of strings
	 */
	function all();

	/**
	 * exists ~ does this named resource exist?
	 * 
	 * @param mixed $name 
	 * @return bool
	 */
	function exists($name);

	/**
	 * toURL ~ export an URL
	 * 
	 * @param string $name 
	 * @return <string>
	 */
	function toURL($name);

	/**
	 * toFile ~ export a file name
	 * 
	 * @param string $name 
	 * @return <string>
	 */
	function toFile($name);

	/**
	 * getResource
	 * 
	 * @param mixed $name 
	 * @return <ResourceHash>
	 */
	function getResource($name=null);
}
