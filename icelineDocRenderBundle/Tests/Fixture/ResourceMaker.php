<?php

namespace icelineLtd\icelineLtdDocRenderBundle\Tests\Fixture;

use icelineLtd\icelineLtdDocRenderBundle\Services\ResourceHash;
use icelineLtd\icelineLtdDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineLtdDocRenderBundle\ResourceInterface;

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


}
