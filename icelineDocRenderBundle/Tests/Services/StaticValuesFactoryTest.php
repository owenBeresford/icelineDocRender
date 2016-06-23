<?php
namespace icelineLtd\icelineLtdDocRenderBundle\Tests\Services;

use icelineLtd\icelineLtdDocRenderBundle\Services\StaticValuesFactory;
use icelineLtd\icelineLtdDocRenderBundle\Tests\Fixture\ResourceMaker;
use icelineLtd\icelineLtdDocRenderBundle\Services\PHPArrayConfig ;
use icelineLtd\icelineLtdDocRenderBundle\Tests\Mocks\MockPageCollection;

$_SERVER['SERVER_ADDR']='127.0.0.1';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-22 at 16:47:58.
 */
class StaticValuesFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StaticValuesFactory
     */
    protected $obj;
	protected $maker;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$cfile=__DIR__.'/../../Resources/config/site_config.php';
        $this->obj = new StaticValuesFactory(new PHPArrayConfig($cfile)) ;
		$this->obj->setPageCollection(new MockPageCollection());

		$this->maker=new  ResourceMaker();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * Generated from @assert $obj->get($in) == 'icelineLtd\icelineLtdDocRenderBundle\ResourceInterface'.
     *
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\StaticValuesFactory::get
     */
    public function testGet()
    {
		$in=$this->maker->makeFramePage001();
        $this->assertEquals(
            'icelineLtd\icelineLtdDocRenderBundle\Services\ResourceHash',
            get_class($this->obj->get($in))
        );
    }

    /**
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\StaticValuesFactory::setSession
     * @todo   Implement testSetSession().
     */
    public function testSetSession()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\StaticValuesFactory::setPageCollection
     * @todo   Implement testSetPageCollection().
     */
    public function testSetPageCollection()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }
}