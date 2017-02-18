<?php

namespace icelineLtd\icelineDocRenderBundle\Tests\Mocks; 

use icelineLtd\icelineDocRenderBundle\PagesCollectionInterface;
use icelineLtd\icelineDocRenderBundle\Services\ResourceHash;
use icelineLtd\icelineDocRenderBundle\Services\Transform\TemplateRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\JSRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\NoTransformRenderer;
use icelineLtd\icelineDocRenderBundle\Tests\Fixture\ResourceMaker;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;

/**
 * 3min to write, faster than using a Mock library
 * 
 * @uses PagesCollectionInterface
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class MockPageCollection implements PagesCollectionInterface
{
	protected $pages;

	/**
	 * __construct
	 * 
	 * @param ConfigInterface $ci 
	 * @return <object>
	 */
	public function __construct() {
		$this->pages=[
				'frame-1',
				'page-1',
				'makeFramePage001',
				'makeFramePage002',
				'other-page',
				'home',
				'home-test',
				'reach-frame',
		];
		$this->maker=new ResourceMaker();
	}

	/**
	 * toURL
	 * 
	 * @param mixed $name 
	 * @return string
	 */
	public function toURL($name):string {
		return "$name";
	}

	/**
	 * toFile
	 * 
	 * @param mixed $name 
	 * @return string
	 */
	public function toFile($name):string {
		return "/var/www/sf2-test4/src/icelineLtd/icelineDocRenderBundle/Resources/pages/$name.wiki";
	}
	
	/**
	 * all
	 * 
	 * @return array of file names
	 */
	function all():array {
		return $this->pages;
	}

	/**
	 * exists
	 * 
	 * @param string $name 
	 * @return bool
	 */
	public function exists($name):bool {
		return in_array($name, $this->pages);
	}

	/**
	 * getResource
	 * 
	 * @param mixed $name 
	 * @access public
	 * @return <self>
	 */
	public function getResource($name=null):ResourceInterface {
		if(method_exists($this->maker, $name)) {
			return $this->maker->$name();
		}
		return new ResourceHash();
	}

	public function getRenderer():TemplateRendererInterface {
		// add attached classes
		$t= new TemplateRenderer();
		$t->setWorker(new JSRenderer());
		$t->setWorker(new NoTransformRenderer());
		return $t;
	}
		
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php

