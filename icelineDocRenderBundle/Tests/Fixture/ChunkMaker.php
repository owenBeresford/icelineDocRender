<?php

namespace icelineLtd\icelineDocRenderBundle\Tests\Fixture;

use icelineLtd\icelineDocRenderBundle\Services\ResourceHash;
use icelineLtd\icelineDocRenderBundle\Services\Chunks\ProgrammaticChunk;
use icelineLtd\icelineDocRenderBundle\ResourceInterface;

/**
 * ResourceMaker 
 * 
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class ChunkMaker
{
	function __construct() {
	}

	function getForm001() {
		$f=create_function("", "return array(
	'id' =>'ffff',
	'action' => 'http://www.google.com',
	'method' => 'GET',
	'wrappers'=>1,
	'encoding'=>'multipart/form-data;charset=UTF-8',
	array('value'=>'', 'type'=>'hidden', 'id'=>'incidentid', 'display'=>'', ),
	array('value'=>'1', 'type'=>'hidden', 'id'=>'peopleid', 'display'=>'', ),
	array('value'=>date('Y-m-d'), 'type'=>'hidden', 'id'=>'dtWhen', 'display'=>'', ),
	array('value'=>'', 'type'=>'text', 'class'=>'required',  'id'=>'comment', 'display'=>'Your comment', ),
	array( 'type'=>'button', 'class'=>'imperialBtn', 'value'=>'Add comment', 'id'=>'btnSubmit'),
										);");

		$t= new ProgrammaticChunk('form01', $f, 'form');
		return $t;
	}

	function getForm002() {
		$f=create_function("", "return array(
	'id' =>'ffff',
	'action' => 'http://www.google.com',
	'method' => 'GET',
	'wrappers'=>1,
	'encoding'=>'multipart/form-data;charset=UTF-8',
	array('value'=>'', 'type'=>'hidden', 'id'=>'incidentid', 'display'=>'', ),
	array('value'=>'1', 'type'=>'hidden', 'id'=>'peopleid', 'display'=>'', ),
	array('value'=>date('Y-m-d'), 'type'=>'hidden', 'id'=>'dtWhen', 'display'=>'', ),
	array('value'=>'', 'type'=>'text', 'class'=>'required',  'id'=>'comment', 'display'=>'Your comment', ),
										);");

		return new ProgrammaticChunk('form01', $f, 'form');
	}

	function getTable001() {
		$f=create_function("", "return array(
	'styles'=>array(),
	'titles'=>array('name', 'value'),
	0 =>array('name'=>'ferrari', 'value'=>'red'),
	1 =>array('name'=>'landrover', 'value'=>'green'),
);");

		return new ProgrammaticChunk('form01', $f, 'form');
	}

	function getTable002() {
	$f=create_function("", "return array(
	'styles'=>array(),
	0 =>array('name'=>'ferrari', 'value'=>'red'),
	1 =>array('name'=>'landrover', 'value'=>'green'),
);");

		return new ProgrammaticChunk('form01', $f, 'form');
	}

	function getTable003() {
 	$f=create_function("", "return array(
	'styles'=>array(),
	'titles'=>false,
	0 =>array('name'=>'ferrari', 'value'=>'red'),
	1 =>array('name'=>'landrover', 'value'=>'green'),
);");

		return new ProgrammaticChunk('form01', $f, 'form');
	}

	function getTablist001() {
 	$f=create_function("", "
return array(
	array(
	'summary-class' => 'sumClass',
	'summary-id' => 's1',
	'tab-summary' => 'fd dg dgdfgdfgdfgdf',
	'tab-class'=>'tabClass',
	'tab-id'=> 't1',
	'tab-body' =>'sdfsd sfssdfsdfsdfsdfsdfsdfsdfsdfsd',
	'button-id'=>'btn1',
	'title'=>'sdfsdsfsdsd',
		),
	array(
	'summary-class' => 'sumClass',
	'summary-id' => 's2',
	'tab-summary' => 'fd dg dgdfgdfgdfgdf',
	'tab-class'=>'tabClass',
	'tab-id'=> 't2',
	'tab-body' =>'sdfsd sfssddfgd fgfgdfgddfgfgsdfsdfsdfsd',
	'button-id'=>'btn2',
	'title'=>'swefawwad',
		),
	array(
	'summary-class' => 'sumClass',
	'summary-id' => 's3',
	'tab-summary' => 'fd dg dgdfgdfgdfgdf',
	'tab-class'=>'tabClass',
	'tab-id'=> 't3',
	'tab-body' =>'sktjfdreyjgndfg drtjd ses ewtykmfgbsweyurkghnbdffr6gyhnhs',
	'button-id'=>'btn3',
	'title'=>'s5utyhndfst',
		),


	'tab-main-class' =>'mainClass',
	'first-tab' =>'btn1',
	'render-local' =>1,
		 );");

		return new ProgrammaticChunk('form01', $f, 'form');
	}

	function getTablist002() {
 	$f=create_function("", "
return array(
	array(
	'summary-class' => 'sumClass',
	'summary-id' => 's1',
	'tab-summary' => 'fd dg dgdfgdfgdfgdf',
	'tab-class'=>'tabClass',
	'tab-id'=> 't1',
	'tab-body' =>'sdfsd sfssdfsdfsdfsdfsdfsdfsdfsdfsd',
	'button-id'=>'btn1',
	'title'=>'sdfsdsfsdsd',
		),
	array(
	'summary-class' => 'sumClass',
	'summary-id' => 's2',
	'tab-summary' => 'fd dg dgdfgdfgdfgdf',
	'tab-class'=>'tabClass',
	'tab-id'=> 't2',
	'tab-body' =>'sdfsd sfssddfgd fgfgdfgddfgfgsdfsdfsdfsd',
	'button-id'=>'btn2',
	'title'=>'swefawwad',
		),
	array(
	'summary-class' => 'sumClass',
	'summary-id' => 's3',
	'tab-summary' => 'fd dg dgdfgdfgdfgdf',
	'tab-class'=>'tabClass',
	'tab-id'=> 't3',
	'tab-body' =>'sktjfdreyjgndfg drtjd ses ewtykmfgbsweyurkghnbdffr6gyhnhs',
	'button-id'=>'btn3',
	'title'=>'s5utyhndfst',
		),
	'tab-main-class' =>'mainClass',
	'first-tab' =>'btn1',
	'render-local' =>1,
				);");

		return new ProgrammaticChunk('form01', $f, 'form');
	}

	function getTablist003() {
 	$f=create_function("", "
return array(
	array(
	'summary-class' => 'sumClass',
	'summary-id' => 's1',
	'tab-summary' => 'fd dg dgdfgdfgdfgdf',
	'tab-class'=>'tabClass',
	'tab-id'=> 't1',
	'tab-body' =>'sdfsd sfssdfsdfsdfsdfsdfsdfsdfsdfsd',
	'button-id'=>'btn1',
	'title'=>'sdfsdsfsdsd',
		),
	array(
	'summary-class' => 'sumClass',
	'summary-id' => 's2',
	'tab-summary' => 'fd dg dgdfgdfgdfgdf',
	'tab-class'=>'tabClass',
	'tab-id'=> 't2',
	'tab-body' =>'sdfsd sfssddfgd fgfgdfgddfgfgsdfsdfsdfsd',
	'button-id'=>'btn2',
	'title'=>'swefawwad',
		),
	array(
	'summary-class' => 'sumClass',
	'summary-id' => 's3',
	'tab-summary' => 'fd dg dgdfgdfgdfgdf',
	'tab-class'=>'tabClass',
	'tab-id'=> 't3',
	'tab-body' =>'sktjfdreyjgndfg drtjd ses ewtykmfgbsweyurkghnbdffr6gyhnhs',
	'button-id'=>'btn3',
	'title'=>'s5utyhndfst',
		),


	'tab-main-class' =>'mainClass',
	'render-local' =>1,

				);");

		return new ProgrammaticChunk('form01', $f, 'form');
	}



}

