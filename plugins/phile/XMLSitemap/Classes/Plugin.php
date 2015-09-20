<?php
/**
 * Plugin class
 */
namespace Phile\Plugin\Phile\XmlSitemap;

use Phile\Utility;
use Phile\Repository\Page;

/**
 * XML Sitemap Plugin
 */
class Plugin extends \Phile\Plugin\AbstractPlugin implements \Phile\Gateway\EventObserverInterface {

	protected $events = ['plugins_loaded' => 'onPluginsLoaded'];

	public function onPluginsLoaded() {
		$uri = $_SERVER['REQUEST_URI'];
		$uri = str_replace('/' . Utility::getInstallPath(), '', $uri);
		if ($uri == '/sitemap.xml') {
			$pageRespository = new Page();
			$pages = $pageRespository->findAll();

			header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
			header('Content-Type: application/xml; charset=UTF-8');
			$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
			foreach( $pages as $page ){
				$pageUrl = preg_replace('/(^|\/)index$/', '', $page->getUrl());
				$lastMod = filemtime($page->getFilePath());
				$xml .= '<url>
							<loc>' . Utility::getBaseUrl() . '/' . $pageUrl . '</loc>
							<lastmod>' . strftime('%Y-%m-%d', $lastMod) . '</lastmod>
						</url>';
			}
			$xml .= '</urlset>';
			header('Content-Type: text/xml');
			echo $xml;
			exit;
		}
	}
}
