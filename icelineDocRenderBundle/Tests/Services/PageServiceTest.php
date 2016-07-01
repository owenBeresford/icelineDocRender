<?php
namespace icelineLtd\icelineDocRenderBundle\Tests\Services;

use icelineLtd\icelineDocRenderBundle\Services\PageService;
use icelineLtd\icelineDocRenderBundle\Services\PHPArrayConfig;
use icelineLtd\icelineDocRenderBundle\Services\StaticValuesFactory;
use icelineLtd\icelineDocRenderBundle\Services\WikiFactory;
use icelineLtd\icelineDocRenderBundle\Tests\Mocks\MockLogger;
use icelineLtd\icelineDocRenderBundle\Tests\Fixture\ResourceMaker;
use icelineLtd\icelineDocRenderBundle\Tests\Mocks\MockPageCollection;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use icelineLtd\icelineDocRenderBundle\ChunkInterface;
use icelineLtd\icelineDocRenderBundle\ConfigInterface;
use icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException;
use icelineLtd\icelineDocRenderBundle\TemplateRendererInterface;
use icelineLtd\icelineDocRenderBundle\Services\Transform\TemplateRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\NoTransformRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\JSRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\CSSRenderer;
use icelineLtd\icelineDocRenderBundle\Services\Render\WikiRenderer;
use Symfony\Component\HttpFoundation\Session\SessionInterface  ;
use icelineLtd\icelineDocRenderBundle\PageServiceInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
$_SERVER['SERVER_ADDR']='127.0.0.1';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-26 at 10:22:21.
 */
class PageServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PageService
     */
    protected $obj;
	protected $maker;

    /**
	 * this is a poor test, as I need to make ALL these objects
     */
    protected function setUp()
    {
		$this->maker=new ResourceMaker();
		$cfile=__DIR__.'/../../Resources/config/site_config.php';
		$conf=new PHPArrayConfig($cfile);
        $this->obj = new PageService();
		$this->obj->setConfig($conf);
		$this->obj->setLog(new MockLogger());
		$this->obj->setResource($this->maker->makeUsableResource($conf));

        $tmp = new TemplateRenderer();
		$static=new StaticValuesFactory($conf) ;
		$static->setPageCollection(new MockPageCollection($conf));
		$tmp->setStaticsFactory( $static);
		$tmp->setWorker(new NoTransformRenderer());
		$tmp->setWorker(new CSSRenderer());
		$tmp->setWorker(new JSRenderer());
		$w=(new WikiFactory( ))->setConfig($conf)->setPageCollection(new MockPageCollection($conf));
		$tmp->setWorker((new WikiRenderer("xhtml" ))->setWiki($w));
// ....
		$this->obj->setTransform($tmp);
		$this->obj->setDebug(false);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * Generated from @assert $obj->render('test001') == 'string'.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageService::render
     */
    public function testRender()
    {
		$page="home-test";
		$page=__DIR__."/../../Resources/pages/$page.wiki";
        $this->assertEquals(
            'string',
            gettype($this->obj->render($page))
        );
    }

    /**
     * Generated from @assert $obj->render('PANDA_STYLE') == \Exception.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageService::render
     */
    public function testRender2()
    {
//		$this->setExpectedException( "icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException");
		$page="PANDA_STYLE";
		$page=__DIR__."/../../Resources/pages/$page.wiki";
        $this->assertEquals(
            'integer',
            gettype($this->obj->render($page))
        );
    }

    public function testRender3()
    {
		$page="home";
		$page=__DIR__."/../../Resources/pages/$page.wiki";
        $this->assertEquals(
            'string',
            gettype($this->obj->render($page))
        );
    }




    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageService::setDebug
     * @todo   Implement testSetDebug().
     */
    public function testSetDebug()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageService::setConfig
     * @todo   Implement testSetConfig().
     */
    public function testSetConfig()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageService::setTransform
     * @todo   Implement testSetTransform().
     */
    public function testSetTransform()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageService::setSession
     * @todo   Implement testSetSession().
     */
    public function testSetSession()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageService::setLog
     * @todo   Implement testSetLog().
     */
    public function testSetLog()
    {
        $this->markTestSkipped(
            'This test has nt been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\PageService::setResource
     * @todo   Implement testSetResource().
     */
    public function testSetResource()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }
}
