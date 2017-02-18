<?php

namespace icelineLtd\icelineDocRenderBundle\Tests\Fixture;

use icelineLtd\icelineDocRenderBundle\Services\ResourceHash;
use icelineLtd\icelineDocRenderBundle\Services\PHPArrayConfig;
use icelineLtd\icelineDocRenderBundle\Services\PHPExecService;
use icelineLtd\icelineDocRenderBundle\Tests\Mocks\MockPageCollection;
use icelineLtd\icelineDocRenderBundle\Tests\Mocks\MockLogger;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\PageMetaChunk;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ParseAsPHP5Chunk;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\NextResourceChunk;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\PlainChunk;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\WikiChunk;
# use icelineLtd\icelineDocRenderBundle\Services\PagesCollection;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;


/**
 * ResourceMaker 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class ResourceMaker
{
	function __construct() {
	}

	function makeFramePage001() {
		$rh=new ResourceHash();

		$rh->setChunk('pagemeta', new ProgrammaticChunk('pagemeta', ['docversion'=>'2.0.0', 'accessgroup'=>1, 'method'=>'GET', 'codeversion'=>'2.0.0' ], 'pagemeta', false));
		$rh->setChunk('test01', new ProgrammaticChunk('test01', '<h1>HEELLO, TEST W0RLD!</h1>', 'html'));
		$rh->setChunk('root', new ProgrammaticChunk('root', '<body>[[test01]]</body>', 'html'));
		$rh->setChunk('do_get', new ProgrammaticChunk('do_get',  create_function( '', 'echo "hello world!\n"; return true;' ), 'do_get'));
		$rh->setChunk('do_post', new ProgrammaticChunk('do_post',  create_function( '', 'echo "hello world!\n"; return true;' ), 'do_post'));
//		$rh->setName('test01');
		return $rh;
	}

	function makeFramePage002() {
		$rh=new ResourceHash();
		$rh->setChunk('pagemeta', new ProgrammaticChunk('pagemeta', ['frame'=>'makeFramePage001', 'docversion'=>'2.0.0', 'accessgroup'=>1, 'method'=>'GET', 'codeversion'=>'2.0.0' ], 'pagemeta'));
		$rh->setChunk('test01', new ProgrammaticChunk('test01', '<h1>HEELLO, TEST W0RLD (test002)!</h1>', 'html'));
//		$rh->setName('test02');
		return $rh;
	}

	function makeFramePage003() {
		$rh=new ResourceHash();
		$rh->setChunk('pagemeta', new ProgrammaticChunk('pagemeta', ['frame'=>'unknownResource', 'docversion'=>'2.0.0', 'accessgroup'=>1, 'method'=>'GET', 'codeversion'=>'2.0.0' ], 'pagemeta'));
		$rh->setChunk('test01', new ProgrammaticChunk('test01', '<h1>HEELLO, TEST W0RLD (test002)!</h1>', 'html'));
//		$rh->setName('test03');
		return $rh;
	}

	function getFilterResrc01() {
		$rh=new ResourceHash();
		$rh->setWorker((new PageMetaChunk('pagemeta', ['frame'=>'unknownResource', 'docversion'=>'2.0.0', 'accessgroup'=>1, 'method'=>'GET', 'codeversion'=>'2.0.0' ], 'pagemeta')));	
        $rh->setWorker(new PlainChunk('test03', '<h1>HEELLO, TEST W0RLD!</h1>', 'html', false));
        $rh->setWorker((new PlainChunk('test04', '<h1>HEELLO, TEST W0RLD!</h1>', 'html', 'encode')));
        $rh->setWorker(new ProgrammaticChunk('test05', ['c'=>'rrterterte','ret'=>false], 'plain', 'json'));
        $rh->setWorker(new NextResourceChunk('test06', 'return "hello world"', 'nextresource', false ));
        $rh->setWorker(new PlainChunk('test03', '<h1>HEELLO, TEST W0RLD!</h1>', 'html', false));
        $rh->setWorker((new PlainChunk('test04', '<h1>HEELLO, TEST W0RLD!</h1>', 'html')));
        $rh->setWorker(new ProgrammaticChunk('test05', '<h1>HEELLO, TEST W0RLD!</h1>', 'html', false));
        $rh->setWorker(new NextResourceChunk('test06', 'return "hello world"', 'nextresource' ));
		return $rh;
	}

	function makeUsableResource(PHPArrayConfig $p) {
		$rh=new ResourceHash();
		$rh->setWorker((new PageMetaChunk('pagemeta', ['frame'=>'unknownResource', 'docversion'=>'2.0.0', 'accessgroup'=>1, 'method'=>'GET', 'codeversion'=>'2.0.0' ], 'pagemeta'))->setConf($p));
		$ttt=new PHPExecService();
		$ttt->setConfig($p);
		$ttt->setLogger( new MockLogger());
        $rh->setWorker(new PlainChunk('test03', '<h1>HEELLO, TEST W0RLD!</h1>', 'html'));
        $rh->setWorker((new WikiChunk('test04', '<h1>HEELLO, TEST W0RLD!</h1>', 'wiki'))->setConf($p));
        $rh->setWorker(new ProgrammaticChunk('test05', '<h1>HEELLO, TEST W0RLD!</h1>', 'html'));
        $rh->setWorker(new NextResourceChunk('test06', 'return "hello world"', 'nextresource' ));
        $rh->setWorker((new ParseAsPHP5Chunk('test02', 'return "hello world"', 'php' ))->setPHP($ttt)->setConf($p)->setResource($rh)->setLog(new MockLogger()));
        $rh->setPageCollection(new MockPageCollection($p));
   		return $rh; 
	}

	function getTabList001() {
		$rh=new ResourceHash(); 

		return $rh;
	}

	function getTable01() {	
		$rh=new ResourceHash(); 

		return $rh;
	}
	
}
