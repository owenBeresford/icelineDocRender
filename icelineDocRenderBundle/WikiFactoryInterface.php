<?php

namespace icelineLtd\icelineLtdDocRenderBundle; 

use icelineLtd\icelineLtdDocRenderBundle\PageCollectionInterface;
use icelineLtd\icelineLtdDocRenderBundle\WikiFactoryInterface;
use icelineLtd\icelineLtdDocRenderBundle\ConfigInterface;

/**
 * WikiFactoryInterface
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
interface WikiFactoryInterface
{

	
	/**
	 * config_wiki ~ function to apply settings to the Wiki library
	 *
	 * This is likely to change, therefore isolated
	 *
	 * References
	 *   http://wiki.horde.org/RuleWikilink
	 *   http://pear.reversefold.com/dokuwiki/text_wiki:ruleraw
	 *   https://github.com/meisteg/wiki/blob/master/class/WikiManager.php
	 * need to add css + other styling
	 * 
	 * @todo any more rules.
	 * @assert $obj->get() == 'Text_Wiki'
	 * Doesn't have many tests, will crash if deps not supplied.  Little branching 
	 */
	public function get();

	
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
