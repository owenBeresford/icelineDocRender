<?php
namespace icelineLtd\icelineDocRenderBundle\Tests\Services\Chunks;

use icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk ;
use icelineLtd\icelineDocRenderBundle\Services\PHPExecService;
use icelineLtd\icelineDocRenderBundle\Services\PHPArrayConfig;
use icelineLtd\icelineDocRenderBundle\Services\ResourceHash;
use icelineLtd\icelineDocRenderBundle\Tests\Mocks\MockLogger;
$_SERVER['SERVER_ADDR']='127.0.0.1';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-04 at 10:06:30.
 */
class ParseAsPHP5ChunkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ParseAsPHP5Chunk
     */
    protected $obj;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->obj = new ParseAsPHP5Chunk("f1", "return 'hello world.';", 'php', false);
		$this->obj->setPHP((new PHPExecService())->setLogger(new MockLogger()));

		$cfile=__DIR__.'/../../../Resources/config/site_config.php';
		$conf=new PHPArrayConfig($cfile);
 		$this->obj->setConf($conf);

		$this->obj->setLog(new MockLogger());
 		$this->obj->setResource(new ResourceHash());

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk::unpack
     * @todo   Implement testUnpack().
     */
    public function testUnpack()
    {
		$ret=$this->obj->unpack( "\nreturn 'house';\n\n",'f2', 'do_get', false);
		$this->assertEquals(get_class($this->obj), get_class($ret) );
//		$this->assertTrue($ret->getData());
// cant exec before validate... 
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk::validate
     * @todo   Implement testValidate().
     */
    public function testValidate01()
    {
// for tests on safe_eval, pls see PHPExecService
		$ret=$this->obj->unpack("\nreturn 'house';\n\n", 'f3', 'do_get', false);
		$this->assertEquals(get_class($this->obj), get_class($ret) );
 		$this->assertTrue($ret->validate());   	
		$this->assertTrue($ret->getData()=='house');
    }

    public function testValidate02()
    {
// for tests on safe_eval, pls see PHPExecService
		$this->setExpectedException('icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException');
		$ret=$this->obj->unpack("\nreturn 'house'\n\n", 'f4', 'do_get', false);
		$this->assertEquals(get_class($this->obj), get_class($ret) );
 		$this->assertFalse($ret->validate());   	
		$this->assertFalse($ret->getData()=='house');
    }

    public function testValidate03()
    {
// for tests on safe_eval, pls see PHPExecService
		$ret=$this->obj->unpack("\nreturn 'house';\n\n", 'f5', 'php', false);
		$this->assertEquals(get_class($this->obj), get_class($ret) );
 		$this->assertTrue($ret->validate());   	
		$this->assertTrue($ret->getData()=='house');
    }



    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk::getData
     * @todo   Implement testGetData().
     */
    public function testGetData01()
    {
// for tests on safe_eval, pls see PHPExecService
		$ret=$this->obj->unpack("\nreturn 'house';\n\n", 'f6', 'php', false);
		$this->assertEquals(get_class($this->obj), get_class($ret) );
 		$this->assertTrue($ret->validate());   	
		$this->assertSame('house', $ret->getData());
 
    }

    public function testGetData02()
    {
// for tests on safe_eval, pls see PHPExecService
		$ret=$this->obj->unpack("\nreturn 'house';\n\n", 'f7', 'do_get', false);
		$this->assertEquals(get_class($this->obj), get_class($ret) );
 		$this->assertTrue($ret->validate());   	

var_dump(__METHOD__,'EEEEEEEEEEEEEEEEEEe', $ret->getData());
		$this->assertTrue( is_callable($ret->getData()));
 
    }



    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk::setPHP
     * @todo   Implement testSetPHP().
     */
    public function testSetPHP()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk::__destruct
     * @todo   Implement test__destruct().
     */
    public function test__destruct()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk::setConf
     * @todo   Implement testSetConf().
     */
    public function testSetConf()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk::setLog
     * @todo   Implement testSetLog().
     */
    public function testSetLog()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk::setResource
     * @todo   Implement testSetResource().
     */
    public function testSetResource()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk::getChunkType
     * @todo   Implement testGetChunkType().
     */
    public function testGetChunkType()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }


}
