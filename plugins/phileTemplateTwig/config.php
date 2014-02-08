<?php

return array(
'cache' => (PRODUCTION) ? CACHE_DIR: false, // To enable Twig caching change this to CACHE_DIR
'autoescape' => false, // Autoescape Twig vars
'debug' => (PRODUCTION) ? false: true // Enable Twig debug
);
