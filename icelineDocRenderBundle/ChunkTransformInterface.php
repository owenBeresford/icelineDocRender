<?php

namespace icelineLtd\icelineDocRenderBundle;

/**
 * ChunkTransformInterface 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
interface ChunkTransformInterface
{
	/**
	 * getChunkType
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType():array;

	/**
	 * render
	 * 
	 * @param ChunkInterface $ci 
	 * @return string
	 */
	function render(ChunkInterface $ci):string;
	
	/**
	 * setFormat
	 * 
	 * @param string $in 
	 * @return <self>
	 */
	function setFormat($in);
	
} 
