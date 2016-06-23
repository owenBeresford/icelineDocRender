<?php
/* {{{ notes for clean_data()
 $names is a seperate index on purpose, it allows better reuse of data arrays.

 Currently supported values in $config
  - regex
  - type --> boolean, int, float, json
  - enum --> as above only for literal values
  - optional
  - reject-resource - i wish
  - reject-message  - i wish
  - min-length
  - max-length
  - trim
  - upper
  - lower
}}} */

$master_browser_barrier					=array(
	'uid'	=> array('type'=>'int', 'optional'=>1, ),
	'lg'	=> array('min-length'=>2, 'max-length'=>5, 'trim'=>1, 'optional'=>1,),
	'eng'	=> array('type'=>'int', 'optional'=>1, ),
	'offset'	=> array('type'=>'int',  ),
	'resource'	=> array('min-length'=>2, 'max-length'=>100, 'trim'=>1, ),
	'asset'	=> array('min-length'=>2, 'max-length'=>100, 'trim'=>1, ),
# on dataflame
# 	'hsh'	=> array('min-length'=>26, 'max-length'=>26, 'trim'=>1, 'optional'=>1, ), # on iceline
# 	'hsh'	=> array('min-length'=>32, 'max-length'=>32, 'trim'=>1, 'optional'=>1, ),
# the neuPeace build ~ 128
 	'hsh'	=> array('min-length'=>128, 'max-length'=>128, 'trim'=>1, 'optional'=>1,),
	'md'	=> array('type'=>'int', 'optional'=>1, ),
	'db'	=> array('type'=>'int', 'optional'=>1, ),
	'view'	=> array('trim'=>1, ),
	'humanname'	=>array('trim'=>1, 'min-length'=>2, 'max-length'=>100, ),
	
	'action' => array('trim'=>1, 'enum'=>array('new', 'update')),
	'name'	=> array('trim'=>1, 'min-length'=>2, 'max-length'=>100,),
	'size'	=> array('trim'=>1, 'min-length'=>2, 'max-length'=>100, 'optional'=>1),

	'date_UK'=>array('trim'=>1, 'min-length'=>6, 'max-length'=>10, 'regex'=>'^[0-9]{1,2}[-\/][0-9]{1,2}[-\/][0-9]{2,4}$'),
# http://www.regular-expressions.info/email.html
# [a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)\b
# http://ntt.cc/2008/05/10/over-10-useful-javascript-regular-expression-functions-to-improve-your-web-applications-efficiency.html
# var isEmail_re       = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/; 
# http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
	'email'		=>array('trim'=>1, 'min-length'=>8, 'max-length'=>100, 'lower'=>1, 'regex'=>'^[a-z0-9!#$%&\'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)\b$'),
	'time_UK'=>array('trim'=>1, 'min-length'=>6, 'max-length'=>10, 'regex'=>'^[0-9]{1,2}:[0-9]{1,2}:[0-9]*$|^[0-9]{1,2}:[0-9]{1,2}AM$|^[0-9]{1,2}:[0-9]{1,2}$'),
	'indexItems'=> array('type'=>'int', ),
# URL: http://reusablecode.blogspot.com/2008/08/isvalidpostcode.html
	'postcode_UK'=>array('trim'=>1, 'min-length'=>5, 'max-length'=>8, 'regex'=>'^([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKS-UW])\ [0-9][ABD-HJLNP-UW-Z]{2}|(GIR\ 0AA)|(SAN\ TA1)|(BFPO\ (C\/O\ )?[0-9]{1,4})|((ASCN|BBND|[BFS]IQQ|PCRN|STHL|TDCU|TKCA)\ 1ZZ))$' ),
	'd'		 => array('trim'=>1, 'type'=>'json', ),
	'some_text'=>array('trim'=>1, 'min-length'=>2, 'max-length'=>15),
	'long_text'=>array('trim'=>1, 'min-length'=>2, 'max-length'=>500),
	'flag'	=>array('trim'=>1,  'min-length'=>2, 'max-length'=>4, 'lower'=>1, 'enum'=>array('yes', 'no', 'true', 'false', 'on', 'off'), 'optional'=>1),
	'numeric'=>array('trim'=>1, 'min-length'=>2, 'max-length'=>8, 'type'=>'int'),

);

# the aliases are should i ever need to have the same form item with two different names, to 
# reduce duplicate definitions in the barrier list...
$master_alias_list						=array(
	'firstname' => 'humanname',
	'lastname'  => 'humanname',
	'txtSearch' => 'humanname',
	'p1_time'	=> 'time_UK',
	'p1_date'	=> 'date_UK',
	'new-hsh'	=> 'hsh',
	'nm'		=> 'humanname',
	'em'		=> 'email',
	'msg'		=> 'long_text',
	'fs'		=> 'some_text',
	'ft'		=> 'some_text',
	'cr'		=> 'some_text',
	'dn'		=> 'some_text',
	'remember'	=> 'flag',
	'rememberYes'=> 'flag',
	'rememberNo'=> 'flag',
	'min'		=> 'flag',
	'f'			=> 'long_text',
	'dt_st'		=> 'numeric',
	'dt_end'		=> 'numeric',
	'project'		=> 'numeric',
	'txt'		=> 'long_text',

);

$clientCookie		=array(
	'storage'				=>array('fs', 'ft', 'cr', 'dn'),
);

$site_settings							=array(
	'site_language' 		=>'en-GB-oed',
	'current_timezone'		=>'Europe/London',
	'network_protocol'		=>'http',
	'site_name'				=>'OwenBeresford\'s very wordy site',
	'page_author'			=>'unlisted, but owenberesford.me.uk',
	'page_charset'			=>'utf-8',
	'rendering_engine'		=>'2',
	'session_name'			=>'hsh',
	'platform_name'			=>'iceline webkit 2.0.0',
	'platform_edition'		=>'2.0.0', # this is a string to support Linux style double dot..
	'log_verbosity'			=> 2, # see head of lib/Log.php for the options
	'log_targets'			=> 5, # annoying can' use my nice constants, not declared yet.
	'cookie_domain'			=>'',
	'log_cache_size'		=>1024,
	'cookie_lifetime'		=>20*60, # seconds
	'error_template'		=>array('report-error-v2'=>2, 'report-error'=>0),
	'extra_markers'			=>array('error-message'),

	'safe_engine'			=>1,
	'page_sections_header'	=>'Table of Contents',
	'resource_dir'			=>'/resource/', # used in the URL....
	'external_dir'			=>'/external/',
	'asset_name'			=>'/asset/', # this setting exists as future planning
	'wiki_render_format'	=>'Xhtml',
	'log_time_format'		=>'jS \o\f M, G:i:s', # see uk.php.net/manual/en/function.date.php
	'human_date'			=>'jS \o\f M, G:i:s',
	'rss_date'			    =>'c',
	'session_dir'			=>'see local', 
	'log_dir'				=>'see local', 
	'site_baseurl'			=>'owenberesford.me.uk',
	'system_alert'			=>'',
	'permit_syslog_leakage' =>0,
	'post_should_wiki'		=>0,
	'revision'				=>"This page is still being revised",
	'404-text'				=>"Unknown or bad resource",
	'escape_urls'			=>1,
	'markup_ascii_quotes'	=>1,
	'emit_log'				=>1,
	'max_post_wait'			=> 120,
	'show_all_errors'		=> 0,
	'description'			=>'Read an exciting article on my site.',
	'iterate_translate'		=>0,
	'is_test'				=>0,
	'extra-js'				=>array('env'),
);

# this is a cache of resources tagged with accessgroup 1
$system_resources		=array(
'403', '404', '500', 'all-get', 'appearance', 'authenticate', 'compat-frame', 'contact-me', 'flow-chunk', 'flow', 'home.old', 'js-min', 'licence', 'mirror', 'privacy', 'reach-frame', 'reach-positional', 'render-source', 'report-error-v2', 'report-error', 'rss', 'site-chart', 'timesheet', 
);

# MY_TEST_MACHINE
# This first address is my actual LAN IP, the second on is forced on me by this cheap router.  soo cracker friendly.

// require(__DIR__."/local_config.php");
if($_SERVER['SERVER_ADDR']== '192.168.27.61' || $_SERVER['SERVER_ADDR']== '192.168.1.10' ||  $_SERVER['SERVER_ADDR']== '127.0.0.1' ||  $_SERVER['SERVER_ADDR']== null) {
	$site_settings['site_baseurl']	='127.0.0.1:81';
	$site_settings['log_dir']		='/tmp/';
	$site_settings['session_dir']	='/tmp/';
	$site_settings['log_verbosity']	=6;
	$site_settings['emit_log']		=1;
	$site_settings['log_targets']	=1 + 4;
	$site_settings['is_test']		=1;	
	$site_settings['show_all_errors']=1;
#	$site_settings['permit_syslog_leakage']=1;
}

/** the following are added in render
$site_settings['lib_dir']				= $lib_dir[0];
$site_settings['res_dir']				= $res_dir;
$site_settings['site_dir']				= $site_dir;
$site_settings['asset_dir']				= $asset_dir;
*/


# maybe lambda function or filename inside lib/render
$renderers								=array(
	1						=> 'minimal_html4',
	2						=> 'combined_html4',
);

$mode_selector				= array(
	0 						=> 'WikiResource',
	1 						=> 'BinaryResource',
	2 						=> 'MultiResource',
);

# this is isn't intended for use in this version, but will allow quick hacks
# i would like all content in the resouces, its easier to brand/ translate etc
$uiStrings					= array(
	'forms'					=>array(),
	'armchair'				=>array(),
);

# http://www.freeformatter.com/mime-types-list.html
$known_files				 =array(
 'jquery.curvycorners.min.js'			=> 'text/javascript',
 'jquery.curvycorners.malsup.js'		=> 'text/javascript',
 'positional.css'						=> 'text/css',
 'reach-positional.css'					=> 'text/css',
 'jquery-ui.css'						=> 'text/css',
 'jquery-1.7.2-min.js'					=> 'text/javascript',
 'jquery-1.10.2.js'						=> 'text/javascript',
 'jquery-1.11.1.js'						=> 'text/javascript',
 'es5-shim.js'							=> 'text/javascript',
 'jquery-ui.min.js'						=> 'text/javascript',
 'jquery.columnizer.js'					=> 'text/javascript',
 'jquery.columniser.js'					=> 'text/javascript',
 'curvycorners.js'						=> 'text/javascript',
 'jquery.validate.min.js'				=> 'text/javascript',
 'jquery-wresize-0.1.1.js'				=> 'text/javascript',
 'jquery-biblio-0.2.0.js'				=> 'text/javascript',
 'jquery-biblio-0.5.0.js'				=> 'text/javascript',
 'jquery-hilight-1.02.js'				=> 'text/javascript',
 'jquery-read-duration-0.1.0.js'		=> 'text/javascript',
 'just-develop-it.doc'					=> 'application/winword',	
 'jdi.sql'								=> 'text/plain',
 'env.js'								=> 'text/javascript',
 'more.js'								=> 'text/javascript',
 'spinnerDefault.png'					=> 'image/png',
 'rss-16x16.png'					=> 'image/png',
 'rss-128x128.png'					=> 'image/png',
 'pig-latin.php'						=> 'text/plain',
 'piglatin.pl'							=> 'text/plain',
 'CountNumeral.c'						=> 'text/plain',
 'FindMostCommon.c'						=> 'text/plain',
 'CAIN.v2.idl' 							=> 'text/xml',
 'PIE.htc'								=> 'text/x-component',
 'curves.php'							=> 'text/css',
 'ajax-closure.js'						=> 'text/javascript',
 'dynamism.js'							=> 'text/javascript',
 'valid-xhtml10.png'					=> 'image/png',
 'workflow.png'						=> 'image/png',
  'workflow2.svg' 					 =>'image/svg+xml',
 'vcss.gif'								=> 'image/gif',
 'hr_pix.gif'							=> 'image/gif',
 'linx-style.css'						=> 'text/css',
 'php-doc.vim'							=> 'text/plain',
 'gplus.png'							=> 'image/png',
 'seventeen74.css'						=> 'text/css',
 'small-twitter-logo.png'				=> 'image/png',
 'small-LinkedIn-logo.jpg'				=> 'image/png',
 'warning-blue.png'						=> 'image/png', 
 'warning-blue-sm.png'					=> 'image/png', 
 'iceline.150x100.png'					=> 'image/png',
 'no-sql.db.png'						=> 'image/png',
 'linkedin.jpg'							=>'image/jpeg',
 'di-media-profile.jpg'					=> 'image/jpeg',
 'qunit-1.11.0.css'						=>'text/css',
 'jquery-hilight-1.02.css'						=>'text/css',
 'qunit-1.11.0.js'						=>'text/javascript',
 'correction.js'						=>'text/javascript',
 'twitter-bird-light-25x25.png'			=> 'image/png', 
 'php-benchmark-2013-07-05' 			=> 'text/plain',
 'php-bencheval-2013-07-09' 			=> 'text/plain',
 'mySociety.zip'						=> 'application/zip',
 'OpenDyslexicAlta-Regular.otf'			=> 'application/x-font-otf',
 'OpenDyslexic-Regular.otf'			=> 'application/x-font-otf',
 'perl-test1.pl'						=> 'text/plain',
 'small-facebook-logo.png'				=> 'image/png',
 'small-LinkedIn-logo.jpg'				=> 'image/jpeg',
 'winter_54_by_sweedies-d5o3owd.jpg'	=> 'image/jpeg',
 'winter_54_by_sweedies-hi-d5o3owd.jpg'	=> 'image/jpeg',
 'winter_54_by_sweedies-med-d5o3owd.jpg'	=> 'image/jpeg',
 'winter_54_by_sweedies-sm-d5o3owd.jpg'	=> 'image/jpeg',
 'small-twitter-logo.png'				=> 'image/png',
 'spoof-voting.zip'						=> 'application/zip',
 'twitter-bird-light-bgs.png'			=> 'image/png',
 'youtube.zf2.tgz'						=> 'application/x-gzip',
 'sf2-demo.II.tgz'						=> 'application/x-gzip',
 'sf2-demo.IV.tgz'						=> 'application/x-gzip',
 'rest-sf2-build3.tgz'					=> 'application/x-gzip',
 'oab1.behat.sf2.tgz'					=> 'application/x-gzip',
 'sf2-demo.III.tgz'						=> 'application/x-gzip',
# http://blog.symbolset.com/properly-serve-webfonts
 'OpenDyslexic-Regular.eot'		=> 'application/vnd.ms-fontobject',
 'ubuntu-regular.eot'			=> 'application/vnd.ms-fontobject',
 'Ubuntu-MediumItalic.eot'		=> 'application/vnd.ms-fontobject',
 'ubuntu-regular-webfont.woff' 	=> 'application/x-font-woff',
  'ubuntu-regular-webfont.svg'  =>'image/svg+xml',
  'ubuntu-regular-webfont.ttf'  =>'application/x-font-ttf',
  'Ubuntu-Regular.ttf'  		=>'application/x-font-ttf',
  'OpenDyslexic-Regular.svg'	=>'image/svg+xml',
  'OpenDyslexic-Regular.ttf'	=>'application/x-font-ttf',
  'OpenDyslexic-Regular.woff'	=>'application/x-font-woff',

				);

#
if(!function_exists('XXX_map_resource_types')) {
function XXX_map_resource_types($access, $type) {
	$out=array(
			0=>'open',
			1=>'system',
			2=>'test',
			3=>'communications',
			4=>'users',
			6=>'admin',
			9=>'demo (no index)',
				);
	

	return $out[$access]." ".$type;
}
}


if(!function_exists('XXX_css_themes')) {
function XXX_css_themes() {
	return array(
			"Choose one" => -1,
			"Icey blue"  =>"blue",
		);
}
}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php
?>
