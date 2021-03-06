<?php
namespace icelineLtd\icelineDocRenderBundle\Tests\Services;

use icelineLtd\icelineDocRenderBundle\Services\PHPArrayConfig;
use icelineLtd\icelineDocRenderBundle\Services\PageCollection;
use icelineLtd\icelineDocRenderBundle\Services\ResourceHash;
use icelineLtd\icelineDocRenderBundle\Tests\Fixture\ResourceMaker;
$_SERVER['SERVER_ADDR']='127.0.0.1';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-22 at 17:27:10.
 */
class PageCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PageCollection
     */
    protected $obj;
	protected $maker;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$this->maker=new ResourceMaker();
		$conf=new PHPArrayConfig('Resources/config/site_config.php');

        $this->obj = new PageCollection($conf);
		$this->obj->setResource($this->maker->makeUsableResource($conf));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageCollection::toURL
     * @todo   Implement testToURL().
     */
    public function testToURL()
    { // really dom't want to read the config file, but cannot guess the URL without doing this 
		$this->assertEquals('string', gettype($this->obj->toURL('home')));
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageCollection::toFile
     * @todo   Implement testToFile().
     */
    public function testToFile()
    {
		$this->assertEquals('string', gettype($this->obj->toFile('home')));
		$this->assertTrue( is_file($this->obj->toFile('home')));

    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageCollection::all
     * @todo   Implement testAll().
     */
    public function testAll()
    {

		$this->assertEquals('array', gettype($this->obj->all()));
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageCollection::getResource
     * @todo   Implement testGetResource().
     */
    public function testGetResource()
    {
		$t=$this->obj->getResource('home');

		$this->assertEquals('object', gettype($t));
		$this->assertEquals('icelineLtd\icelineDocRenderBundle\Services\ResourceHash', get_class($t));
		
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageCollection::exists
     * @todo   Implement testExists().
     */
    public function testExists()
    {
		$this->assertTrue( $this->obj->exists('home'));
		$this->assertFalse( $this->obj->exists('PANDA!'));
		
    }
}
