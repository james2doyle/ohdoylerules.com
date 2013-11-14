<?php

// Override any of the default settings below:

$config['site_title'] = 'James Doyle'; // Site title
$config['base_url'] = 'http://ohdoylerules.com'; // Override base URL (e.g. http://example.com)
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

$config['author_blurb'] = 'I am the director and head developer at <a href="http://warpaintmedia.ca" target="_blank" title="WARPAINT Media">WARPAINT Media</a>. I create a lot of open source projects. Check me out on Github.';

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

$config['gravatar'] = get_gravatar('james2doyle@gmail.com', 100);

$config['plugins'] = array(
	'phileDemoPlugin' => array('active' => true),
	'phileParserMarkdown' => array('active' => false),
	'phileSundown' => array('active' => true),
	'phileXMLSitemap' => array('active' => true),
	'phileTwigFilters' => array('active' => true)
	);

return $config;
