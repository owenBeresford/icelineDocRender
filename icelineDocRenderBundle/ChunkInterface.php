<?php

namespace icelineLtd\icelineDocRenderBundle;

/**
 * ChunkInterface 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 // }}}
 */
interface ChunkInterface
{
	/**
	 * label for sections of the data files 
	 * 
	 * @const string
	 */
	const PAGE_META='pagemeta';
	const COMMENT='comment';
	const NEXT_RESOURCE='nextresource';
	const DO_GET='do_get';
	const DO_POST ='do_post';
	const POST_ARGS='postargs';
	const GET_ARGS='getargs';
	const PAGE_INCLUDE='include';
	const PHP5 ="php";
	const TABLE="table";
	const TABLIST="tablist";
	const FORM="form";
	const PLAIN="plain";
	const HTML="html";
	const WIKI="wiki";
	const JS="js";
	const CSS="css";
	

	/**
	 * labels for attrib inside the meta section 
	 * 
	 * @const string
	 */
	const DOCVERSION='docversion';
	const ACCESSGROUP='accessgroup';
	const METHOD='method';
	const CODEVERSION='codeversion';
	const FRAME='frame';
	const ROOTNAME='root';

	/**
	 * current filters
	 * 
	 * @const string
	 */
	const NOWRAP='nowrap';
	const ESCAPE='escape';
	const ENCODE='encode';
	const JSON='json';
	
	/**
	 * getChunkType
	 * 
	 * @static
	 * @return string
	 */
	static function getChunkType();

	/**
	 * unpack ~ transform data into internal structure
	 * 
	 * @param string $data 
	 * @return ChunkInterface
	 */
	function unpack($data, $name, $filter);

	/**
	 * validate
	 * 
	 * @return bool
	 */
	function validate();

	/**
	 * getName
	 * 
	 * @return string of name
	 */
	function getName();

	/**
	 * getData
	 * 
	 * @return mixed, the unpacked chunk
	 */
	function getData();

	/**
	 * getFilter
	 * 
	 * @return <self>
	 */
	function getFilter();
	
	/**
	 * setData
	 * 
	 * @return <self>
	 */
	function setData($new);

	/**
	 * getAttribute ~ if chunk supports attribs, return requested data
	 * 
	 * @param string $name 
	 * @return mixed, probably a string
	 */
	function getAttribute($name);
} 

