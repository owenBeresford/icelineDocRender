<?php
namespace icelineLtd\icelineDocRenderBundle\Tests\Services;

use icelineLtd\icelineDocRenderBundle\Services\Cache;
use icelineLtd\icelineDocRenderBundle\Services\PHPArrayConfig;

$_SERVER['SERVER_ADDR']='127.0.0.1';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-08 at 21:54:18.
 */
class CacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Cache
     */
    protected $obj;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {

		$cfile=__DIR__.'/../../Resources/config/site_config.php';
		$conf=new PHPArrayConfig($cfile);
        $this->obj = new Cache($conf);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * Generated from @assert $obj->hit('PANDA') == false.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\Cache::hit
     */
    public function testHit()
    {
        $this->assertFalse(
            $this->obj->hit(__DIR__.'/../../Resources/pages/PANDA.wiki')
        );
    }

    /**
     * Generated from @assert $obj->hit('home') == true.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\Cache::hit
     */
    public function testHit2()
    {
		touch(__DIR__.'/../../../../../app/cache/cache/home.html');
        $this->assertTrue(
            $this->obj->hit( __DIR__.'/../../Resources/pages/home.wiki')
        );
		unlink(__DIR__.'/../../../../../app/cache/cache/home.html');
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Cache::entry
     * @todo   Implement testEntry().
     */
    public function testEntry()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Cache::put
     * @todo   Implement testPut().
     */
    public function testPut()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }
}
