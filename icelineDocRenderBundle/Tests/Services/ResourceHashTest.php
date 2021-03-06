<?php
namespace icelineLtd\icelineDocRenderBundle\Tests\Services;

use icelineLtd\icelineDocRenderBundle\Services\ResourceHash;
use icelineLtd\icelineDocRenderBundle\Services\PHPArrayConfig;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\PlainChunk;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\PageMetaChunk;
use icelineLtd\icelineDocRenderBundle\Tests\Fixture\ResourceMaker;
$_SERVER['SERVER_ADDR']='127.0.0.1';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-04 at 19:28:43.
 */
class ResourceHashTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResourceHash
     */
    protected $obj;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$maker=new ResourceMaker(); 
        $this->obj = $maker->makeUsableResource( new PHPArrayConfig('Resources/config/site_config.php'));
   }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setWorker
     * @todo   Implement testSetWorker().
     */
    public function testSetWorker01()
    {
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setWorker(new PlainChunk("ch".__LINE__, "gdgdgdf", "html") ))
        );
         $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setWorker(new PageMetaChunk("ch".__LINE__, "gdgdgdf", "html") ))
        );
 
    }

    public function testSetWorker02()
    {
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setWorker(new PlainChunk("ch".__LINE__, "gdgdgdf", "html") ))
        );
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setWorker(new PlainChunk("ch".__LINE__, "gdgdgdf", "html") ))
        );

    }



    /**
     * Generated from @assert $obj->setChunk("ssdf", "gdgdg", 'wiki', false) == $obj.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setChunkRaw
     */
    public function testSetChunkRaw()
    {
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setChunkRaw("ssdf", "gdgdg", 'wiki', false))
        );
    }

    /**
     * Generated from @assert $obj->setChunk(1, "gdgdg", 'wiki', false) == $obj.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setChunkRaw
     */
    public function testSetChunkRaw2()
    {
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setChunkRaw(1, "gdgdg", 'wiki', false))
        );
    }

    /**
     * Generated from @assert $obj->setChunk(new StdClass(), "gdgdg", 'wiki', false) == $obj.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setChunkRaw
     */
    public function testSetChunkRaw3()
    {
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setChunkRaw(new \StdClass(), "gdgdg", 'wiki', false))
        );
    }

    /**
     * Generated from @assert $obj->setChunk(false, "gdgdg", 'wiki', false) == $obj.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setChunkRaw
     */
    public function testSetChunkRaw4()
    {
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setChunkRaw(false, "gdgdg", 'wiki', false))
        );
    }

    /**
     * Generated from @assert $obj->setChunk("ssdf", $in) == $obj.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setChunk
     */
    public function testSetChunk()
    {
		$in=new PlainChunk("ch".__LINE__, "XX XX XX", 'html');
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setChunk("ssdf", $in))
        );
    }

    /**
     * Generated from @assert $obj->setChunk(1, $in) == $obj.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setChunk
     */
    public function testSetChunk2()
    {
		$in=new PlainChunk("ch".__LINE__, "XX XX XX", 'html');
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setChunk(1, $in))
        );
    }

    /**
     * Generated from @assert $obj->setChunk(new StdClass(), $in) == $obj.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setChunk
     */
    public function testSetChunk3()
    {
		$in=new PlainChunk("ch".__LINE__, "XX XX XX", 'html');
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setChunk(new \StdClass(), $in))
        );
    }

    /**
     * Generated from @assert $obj->setChunk(false, $in) == $obj.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setChunk
     */
    public function testSetChunk4()
    {
		$in=new PlainChunk("ch".__LINE__, "XX XX XX", 'html');
        $this->assertEquals(
            get_class($this->obj),
            get_class($this->obj->setChunk(false, $in))
        );
    }

    /**
     * Generated from @assert $obji->appendChunk("f1", $in) == $obj.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::appendChunk
     */
    public function testAppendChunk()
    {
		$in=new PlainChunk("ch".__LINE__, "XX XX XX", 'html');
        $this->assertEquals(
            get_class($this->obj ),
            get_class($this->obj->appendChunk("f1", $in))
        );
    }

    /**
     * Generated from @assert $obj->merge($in) == $in.
     *
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::merge
     */
    public function testMerge()
    {
		$m=new ResourceMaker();
		$in=$m->makeFramePage001();

        $this->assertEquals(
            get_class($in) ,
            get_class($this->obj->merge($in))
        );
    }

	/**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setContentFromFile
     * @todo   Implement testSetContentFromFile().
     */
    public function testSetContentFromFile01()
    {
		$this->assertSame(
				get_class($this->obj),
				get_class($this->obj->setContentFromFile(__DIR__.'/../../Resources/pages/home.wiki'))
							);
	}

    public function testSetContentFromFile02()
    {
		$this->setExpectedException("icelineLtd\icelineDocRenderBundle\Exceptions\BadResourceException");
		$this->assertSame(
				get_class($this->obj),
				get_class($this->obj->setContentFromFile(__DIR__.'/../../Resources/pages/PANDA.wiki'))
							);
	}


    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setContent
     * @todo   Implement testSetContent().
     */
    public function testSetContent()
    {
		$wiki=<<<EOWIKI
{{pagemeta
|Name                = home
|Title               = IT and process
|Author              = Owen Beresford
|DocVersion          = 2.0
|AccessGroup         = 0
|Method              = GET
|CodeVersion         = 2.0.0
|Strapline           = Literate programming: 100,000 words and rising
|Keywords            = home index
|frame 			= reach-frame
|description 		= Assorted articles and processes on the current state of software engineering. Please click through to articles... 
}}
{{plain status
++ Current status:
This is a simple site with alot of words.  My objective is communication. 
When I don't have large projects going on, I am adding more content (and when I do, I am scribbling notes to publish later). 

Many of these articles are to show non-visible artifacts.  If I am re-engineering your sales platform, I will make many changes.  Looking at the front-end skin of another sales platform doesn't say whether I am good at re-engineering, or not.  That I can write the article means I know about the subject.
}}
{{plain about
++ About the site:
You are interested in reading this site as: 
# I have sent you a link.
# You are looking for a software developer.
# You looking to solve a problem, and are reading.
# You are randomly reading about technology.

The site is:
# Lots of material removed from my CV, so I can keep that concise.
# Articles on technology.
# Project notes for various bits of software I have created.
# Assessments of various technology and processes.  
# Mostly, alot of words.  

+++ Change list
This list got too big, I moved it to ((change-list|here)).

}}
EOWIKI;

			$this->assertSame(
				get_class($this->obj),
				get_class($this->obj->setContent($wiki))
							);
	}

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::renderable
     * @todo   Implement testRenderable().
     */
    public function testRenderable()
    {
		$this->assertFalse($this->obj->renderable('pagemeta'));
		$this->assertFalse($this->obj->renderable('do_get'));
		$this->assertTrue($this->obj->renderable('plain'));
		$this->assertTrue($this->obj->renderable('html'));
    }





    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::__clone
     * @todo   Implement test__clone().
     */
    public function test__clone()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::setPageCollection
     * @todo   Implement testSetPageCollection().
     */
    public function testSetPageCollection()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

       /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::getChunk
     * @todo   Implement testGetChunk().
     */
    public function testGetChunk()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::addChunk
     * @todo   Implement testAddChunk().
     */
    public function testAddChunk()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::name
     * @todo   Implement testName().
     */
    public function testName()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::getAllChunks
     * @todo   Implement testGetAllChunks().
     */
    public function testGetAllChunks()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::getMetaAttrib
     * @todo   Implement testGetMetaAttrib().
     */
    public function testGetMetaAttrib()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::rewind
     * @todo   Implement testRewind().
     */
    public function testRewind()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::current
     * @todo   Implement testCurrent().
     */
    public function testCurrent()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::key
     * @todo   Implement testKey().
     */
    public function testKey()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::next
     * @todo   Implement testNext().
     */
    public function testNext()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::valid
     * @todo   Implement testValid().
     */
    public function testValid()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers icelineLtd\icelineDocRenderBundle\Services\ResourceHash::get_meta
     * @todo   Implement testGet_meta().
     */
    public function testGet_meta()
    {
        $this->markTestSkipped(
            'This test has not been implemented yet.'
        );
    }
}
