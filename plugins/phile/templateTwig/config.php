<?php
/** config file */
return array(
	'template-extension' => 'html', // template file extension
	'cache'      => (PRODUCTION) ? CACHE_DIR : false, // To enable Twig caching change this to CACHE_DIR
	'autoescape' => false, // Autoescape Twig vars
	'debug'      => (PRODUCTION) ? false : true // Enable Twig debug
);
