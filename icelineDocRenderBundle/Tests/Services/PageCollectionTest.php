<?php
namespace icelineLtd\icelineDocRenderBundle\Tests\Services;

use icelineLtd\icelineDocRenderBundle\Services\PHPArrayConfig;
use icelineLtd\icelineDocRenderBundle\Services\PageCollection;
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

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {

        $this->obj = new PageCollection(new PHPArrayConfig('Resources/config/site_config.php'));
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
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageCollection::toFile
     * @todo   Implement testToFile().
     */
    public function testToFile()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageCollection::all
     * @todo   Implement testAll().
     */
    public function testAll()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageCollection::getResource
     * @todo   Implement testGetResource().
     */
    public function testGetResource()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageCollection::exists
     * @todo   Implement testExists().
     */
    public function testExists()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
