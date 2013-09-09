<?php

/**
 * Generate an xml sitemap for Pico
 *
 * @author Dave Kinsella
 * @link https://github.com/Techn0tic/Pico_Sitemap
 * @license http://opensource.org/licenses/MIT
 */
class Pico_Sitemap {

	private $is_sitemap;

	public function __construct(){
		$this->is_sitemap = false;
	}

	public function request_url(&$url)
	{
		if($url == 'sitemap.xml') $this->is_sitemap = true;
	}

	public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page){
		if($this->is_sitemap){
			$xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
			foreach( $pages as $page ){
				$xml .= '<url>';
				$xml .= '<loc>'.$page['url'].'</loc>';
				$xml .= '<lastmod>'.$page['date'].'</lastmod>';
				$xml .= '</url>';
			}
			$xml .= '</urlset>';
			header('Content-Type: text/xml');
			die($xml);
		}
	}

}

?>