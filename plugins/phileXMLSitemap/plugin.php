<?php

/**
 * XML Sitemap Plugin
 */
class PhileXMLSitemap extends \Phile\Plugin\AbstractPlugin implements \Phile\EventObserverInterface {
	public function __construct() {
		\Phile\Event::registerEvent('plugins_loaded', $this);
	}

	public function on($eventKey, $data = null) {
		
		// check $eventKey for which you have registered
		if ($eventKey == 'plugins_loaded') {
			$uri    = $_SERVER['REQUEST_URI'];
			$uri    = str_replace('/' . \Phile\Utility::getInstallPath(), '', $uri);
			if ($uri == '/sitemap.xml') {
			 	$pageRespository = new \Phile\Repository\Page();
				$pages  = $pageRespository->findAll();
			 	
			 	header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
				header('Content-Type: application/xml; charset=UTF-8');
				$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                foreach( $pages as $page ){
	                $lastMod    = filemtime($page->getFilePath());
					$xml .= '<url>
								<loc>'. \Phile\Utility::getBaseUrl() . '/' . $page->getUrl().'</loc>
								<lastmod>'.strftime('%Y-%m-%d', $lastMod).'</lastmod>
							</url>';
                }
                $xml .= '</urlset>';
                header('Content-Type: text/xml');
                echo $xml;
				exit;
			}
		}
	}
}
