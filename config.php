<?php

// use this config file to overwrite the defaults from default_config.php
// or to make local config changes.
$config = array();
$config['encryptionKey'] = 'P6K5CYb6RRXwRL3O?}b8JvRjhydM2Ltnw=L4uyYmp46tNUkMTVTKCJ?/RiT/HAq7';

$config['site_title'] = 'James Doyle'; // Site title
// $config['base_url'] = 'http://ohdoylerules.com'; // Override base URL (e.g. http://example.com)
$config['theme'] = 'dist'; // Set the theme (defaults to "default")
$config['date_format'] = 'F jS, Y'; // Set the PHP date format

$config['pages_order'] = 'meta.date:desc'; // Order pages "asc" or "desc"
// figure out the timezone
$timezone = (ini_get('date.timezone')) ? ini_get('date.timezone') : 'UTC';
$config['timezone'] = $timezone; // The default timezone
// To add a custom config setting:

$config['email'] = 'james2doyle@gmail.com';
$config['twitter'] = 'james2doyle';
$config['github'] = 'james2doyle';
$config['googleplus'] = '109231487156400680487';
$config['referral_code'] = "https://www.digitalocean.com/?refcode=baa9cb97566c";

$config['author_blurb'] = 'I am the director and lead developer at <a href="http://warpaintmedia.ca" target="_blank" title="WARPAINT Media">WARPAINT Media</a>, co-creator of <a href="https://github.com/PhileCMS/Phile" title="PhileCMS" target="_blank">PhileCMS</a>. I am a huge Open Source advocate and contributor to a lot of projects in my community. When I am not sitting at a computer, I am trying to perfect some other skill.';

$config['author_helpline_title'] = 'Need Help?';
$config['author_helpline'] = 'Are you having trouble with something? I can give you some advice, instruction, or <em>even look at your code</em>! All of this, for only <a href="http://bitcoin.com/" target="_blank" title="What is BitCoin?"><strong>0.02btc/hour</strong></a>. Or we can work something out.';

$config['gravatar'] = 'http://www.gravatar.com/avatar/b7375c88e1864c4ddf0d7bdab58e4cca?s=100&d=mm&r=g';

// looks for a lock file for knowing what type of environment we are in
define('PRODUCTION', !file_exists('./localhost'));

$config['plugins'] = array(
	'phile\\XmlSitemap' => array('active' => true),
	'phile\\TwigFilters' => array('active' => true),
	'phile\\RssFeed' => array('active' => true),
	'phile\\phpFastCache' => array('active' => PRODUCTION)
	);

return $config;
