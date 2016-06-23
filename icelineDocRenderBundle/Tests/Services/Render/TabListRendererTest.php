<?php
namespace icelineLtd\icelineLtdDocRenderBundle\Tests\Services\Render;

use icelineLtd\icelineLtdDocRenderBundle\Services\HTMLise;
use icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer;
use icelineLtd\icelineLtdDocRenderBundle\Services\PHPArrayConfig;
use icelineLtd\icelineLtdDocRenderBundle\Tests\Fixture\ChunkMaker;
use icelineLtd\icelineLtdDocRenderBundle\Tests\Mocks\MockPageCollection;
$_SERVER['SERVER_ADDR']='127.0.0.1';


/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-22 at 22:06:47.
 */
class TabListRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TabListRenderer
     */
    protected $obj;
	protected $maker;
	protected $pages;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$cfile=__DIR__.'/../../../Resources/config/site_config.php';
		$c=new PHPArrayConfig($cfile);
        $this->obj = new TabListRenderer();
		$this->pages=new MockPageCollection();
		$this->obj->setResourceHash($this->pages->getResource('empty'));
		$this->obj->setTemplateRenderer($this->pages->getRenderer());
		$this->obj->setConfig($c);
		
		$this->maker=new ChunkMaker();

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * Generated from @assert $obj->render($in) == 'string'.
     *
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer::render
     */
    public function testRender1()
    {
		$in=$this->maker->getTablist001();
        $this->assertEquals(
            'string',
            gettype($this->obj->render($in))
        );
    }

    /**
     * Generated from @assert $obj->render($in) == 'string'.
     *
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer::render
     */
    public function testRender2()
    {
		$in=$this->maker->getTablist002();
        $this->assertEquals(
            'string',
            gettype($this->obj->render($in))
        );
    }

    /**
     * Generated from @assert $obj->render($in) == 'string'.
     *
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer::render
     */
    public function testRender3()
    {
		$in=$this->maker->getTablist003();
		$this->setExpectedException('icelineLtd\icelineLtdDocRenderBundle\Exceptions\BadResourceException');
        $this->assertEquals(
            'string',
            gettype($this->obj->render($in))
        );
    }



    /**
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer::setConfig
     * @todo   Implement testSetConfig().
     */
    public function testSetConfig()
    {
        // Remove the following lines when you implement this test.
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer::setResourceHash
     * @todo   Implement testSetResourceHash().
     */
    public function testSetResourceHash()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer::setFormat
     * @todo   Implement testSetFormat().
     */
    public function testSetFormat()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer::setTemplateRenderer
     * @todo   Implement testSetTemplateRenderer().
     */
    public function testSetTemplateRenderer()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer::getChunkType
     * @todo   Implement testGetChunkType().
     */
    public function testGetChunkType()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineLtdDocRenderBundle\Services\Render\TabListRenderer::makeTabList
     * @todo   Implement testMakeTabList().
     */
    public function testMakeTabList()
    {
        // Remove the following lines when you implement this test.
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }
}