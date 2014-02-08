<?php

// use this config file to overwrite the defaults from default_config.php
// or to make local config changes.
$config = array();
$config['encryptionKey'] = 'P6K5CYb6RRXwRL3O?}b8JvRjhydM2Ltnw=L4uyYmp46tNUkMTVTKCJ?/RiT/HAq7';

$config['site_title'] = 'James Doyle'; // Site title
// $config['base_url'] = 'http://ohdoylerules.com'; // Override base URL (e.g. http://example.com)
$config['theme'] = 'dist'; // Set the theme (defaults to "default")
$config['date_format'] = 'F jS, Y'; // Set the PHP date format

$config['pages_order_by'] = 'date'; // Order pages by "alpha" or "date"
$config['pages_order'] = 'desc'; // Order pages "asc" or "desc"
// figure out the timezone
$timezone = (ini_get('date.timezone')) ? ini_get('date.timezone') : 'UTC';
$config['timezone'] = $timezone; // The default timezone
// To add a custom config setting:

$config['email'] = 'james2doyle@gmail.com';
$config['twitter'] = 'james2doyle';
$config['github'] = 'james2doyle';
$config['googleplus'] = '109231487156400680487';

$config['author_blurb'] = 'I am the director and lead developer at <a href="http://warpaintmedia.ca" target="_blank" title="WARPAINT Media">WARPAINT Media</a>. I am a huge Open Source advocate and contributor to a lot of projects in my community. When I am not sitting at a computer, I am trying to perfect some other skill.';

$config['author_helpline_title'] = 'Need Help?';
$config['author_helpline'] = 'Are you having trouble with something? I can give you some advice, instruction, or <em>even look at your code</em>! All of this, for only <a href="http://bitcoin.com/" target="_blank" title="What is BitCoin?"><strong>0.02btc/hour</strong></a>. Or we can work something out.';

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */

function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}

// $config['gravatar'] = get_gravatar('james2doyle@gmail.com', 100);
$config['gravatar'] = 'http://www.gravatar.com/avatar/b7375c88e1864c4ddf0d7bdab58e4cca?s=100&d=mm&r=g';

define('PRODUCTION', false);

$config['plugins'] = array(
	'phileDemoPlugin' => array('active' => false),
	'phileParserMarkdown' => array('active' => false),
	'phileSundown' => array('active' => true),
	'phileXMLSitemap' => array('active' => true),
	'phileTwigFilters' => array('active' => true),
	'phileRSSFeed' => array('active' => true),
	'philePhpFastCache' => array('active' => PRODUCTION),
	'phileSimpleFileDataPersistence' => array('active' => PRODUCTION)
	);

return $config;
