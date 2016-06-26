<?php

namespace icelineLtd\icelineDocRenderBundle;

/**
 * ResourceInterface 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
interface ResourceInterface extends \Iterator
{
	/**
	 * markers for unpacking the files with
	 * 
	 * @const string
	 */
	const CHUNK_START	='{{';
	const CHUNK_END 	='}}';
	const LIST_SPLIT ='|';
	const AVP_SPLIT='=';
	const LINE_ENDING="\n";
	const VALUE_LIST_SPLIT=',';
	const MARKER_START='[[';
	const MARKER_END=']]';
	
	/**
	 * sizes & versions
	 * 
	 * @const int
	 */
	const MIMIMUM_AVP=5;
	const MY_PAGE_EDITION='2.0.0';
/* I don' know what these are yet..
				1,				# 7
				30,				# 8
				5, 				# 9
*/	


	/**
	 * request types, only the first 2 are used 
	 * 
	 * @const int
	 */
	const HTTP_GET=1;
	const HTTP_POST=2;
	const HTTP_PUT=4;
	const HTTP_DELETE=8;
	const HTTP_PATCH=16;
	const HTTP_OPTIONS=32;
	const HTTP_EITHER=64;
	
	/**
	 * setContentFromFile
	 * 
	 * @param string $fn 
	 * @return <self>
	 */
	function setContentFromFile($fn);
	
	/**
	 * setContent
	 * 
	 * @param string $data 
	 * @return <self>
	 */
	function setContent($data);

	/**
	 * getChunk
	 * 
	 * @param string $name 
	 * @return ChunkInterface
	 */
	function getChunk($name);

	/**
	 * setChunk
	 * 
	 * @param string OR int $name 
	 * @param mixed $value 
	 * @param string $format OPTIONAL default=wiki
	 * @param string $filter OPTIONAL default=null
	 * @return <self>
	 */
	function setChunkRaw($name, $value, $format='wiki', $filter=false);

	/**
	 * getAllChunks
	 * 
	 * @return an array of chunks
	 */
	function getAllChunks();

	/**
	 * getMetaAttrib ~ if chunk supports attribs, return requested data
	 * 
	 * @param string $name 
	 * @return <self>
	 */
	function getMetaAttrib($name);

	/**
	 * addChunk
	 * 
	 * @param ChunkInterface $ci 
	 * @return <self>
	 */
	function addChunk(ChunkInterface $ci);
	
	/**
	 * setChunk
	 * 
	 * @param string $name 
	 * @param ChunkInterface $chunk 
	 * @return <self>
	 */
	function setChunk($name, ChunkInterface $chunk);
	
	/**
	 * appendChunk
	 * 
	 * @param string $name 
	 * @param string $value 
	 * @return <self>
	 */
	function appendChunk($name, $value) ;

	/**
	 * merge
	 * 
	 * @param ResourceInterface $in 
	 * @return <self>
	 */
	function merge(ResourceInterface $in);
	
	/**
	 * name ~ the resource name
	 * 
	 * @return <self>
	 */
	function name();
}
