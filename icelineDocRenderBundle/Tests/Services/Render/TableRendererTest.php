<?php
namespace icelineLtd\icelineDocRenderBundle\Tests\Services\Render;

use icelineLtd\icelineDocRenderBundle\Services\Render\TableRenderer;
use icelineLtd\icelineDocRenderBundle\Services\HTMLise;
use icelineLtd\icelineDocRenderBundle\Services\PHPArrayConfig;
use icelineLtd\icelineDocRenderBundle\Services\StaticValuesFactory;
use icelineLtd\icelineDocRenderBundle\Services\WikiFactory;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk;
use icelineLtd\icelineDocRenderBundle\Tests\Mocks\MockLogger;
use icelineLtd\icelineDocRenderBundle\Tests\Fixture\ResourceMaker;
use icelineLtd\icelineDocRenderBundle\Tests\Mocks\MockPageCollection;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineDocRenderBundle\TemplateRendererInterface;
use icelineLtd\icelineDocRenderBundle\Services\Transform\TemplateRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Transform\TemplateMerge;
use icelineLtd\icelineDocRenderBundle\Services\Render\NoTransformRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\JSRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\CSSRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\WikiRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\TabListRenderer;
use Symfony\Component\HttpFoundation\Session\SessionInterface  ;
use icelineLtd\icelineDocRenderBundle\PageServiceInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
$_SERVER['SERVER_ADDR']='127.0.0.1';


/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-03 at 15:03:14.
 */
class TableRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TableRenderer
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
        $this->obj = new TableRenderer();
		$cfile=__DIR__.'/../../../Resources/config/site_config.php';
		$conf=new PHPArrayConfig($cfile);
		$this->obj->setConfig($conf);

		$this->obj->setHTMLise((new HTMLise([], []))->setConfig($conf));	
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
     * @covers icelineLtd\icelineDocRenderBundle\Services\Render\TableRenderer::render
     */
    public function testRender01()
    {
		$in=new ProgrammaticChunk('table01', function() { 
			return ['titles'=>["aTitle", "bTitle"], 0=>["dgdg", "dfgdfgd"], 1=>["gdgdf", "dfgfgdf"] ]; 
													}, 'table', false);
		$out=$this->obj->render($in);

        $this->assertEquals( 'string', gettype($out) );
		$this->assertTrue(2===preg_match_all("/table/", $out) );
    }

    public function testRender02()
    {
		$in=new ProgrammaticChunk('table02', function() { 
			return [ 0=>["col1"=>"dgdg", "col2"=>"dfgdfgd"], 1=>["col1"=>"gdgdf", "col2"=>"dfgfgdf"] ]; 
													}, 'table', false);
		$out=$this->obj->render($in);

        $this->assertEquals( 'string', gettype($out) );
		$this->assertTrue(2===preg_match_all("/table/", $out) );
    }

// add stuff involving CSS


    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Render\TableRenderer::setConfig
     * @todo   Implement testSetConfig().
     */
    public function testSetConfig()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Render\TableRenderer::setHTMLise
     * @todo   Implement testSetHTMLise().
     */
    public function testSetHTMLise()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Render\TableRenderer::setFormat
     * @todo   Implement testSetFormat().
     */
    public function testSetFormat()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Render\TableRenderer::getChunkType
     * @todo   Implement testGetChunkType().
     */
    public function testGetChunkType()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }
}
