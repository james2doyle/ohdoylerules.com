<?php
/**
 * Plugin class
 */
namespace Phile\Plugin\Phile\RssFeed;
use Phile\Registry;
use Phile\Utility;
use Phile\Repository\Page;

/**
 * Phile RSS Feed Plugin
 * converted from https://github.com/gilbitron/Pico-RSS-Plugin
 */
class Plugin extends \Phile\Plugin\AbstractPlugin implements \Phile\Gateway\EventObserverInterface {

	private $config;

	protected $events = ['plugins_loaded' => 'onPluginsLoaded'];

	// this is a simple function to render a PHP file based on an input array
	private function render_file($filename, $vars = null) {
		if (is_array($vars) && !empty($vars)) {
			extract($vars);
		}
		ob_start();
		include Utility::resolveFilePath("MOD:phile/rssFeed/".$filename);
		return ob_get_clean();
	}

	public function onPluginsLoaded() {
		$this->config = Registry::get('Phile_Settings');
		$uri = str_replace('/' . Utility::getInstallPath(), '', $_SERVER['REQUEST_URI']);
		if ($uri == $this->settings['feed_url']) {
			$pageRespository = new Page();
			$pages = $pageRespository->findAll();
			// merge the arrays to bind the settings to the view
			$this->config = array_merge($this->config, $this->settings);
			$this->config['pages'] = array();
			// convert the pages into key => values and not an object
			for ($i=0; $i < count($pages); $i++) {
				/** @var \Phile\Model\Page $page */
				$page = $pages[$i];

				$meta = $page->getMeta();
				$this->config['pages'][] = array(
					'title' => $page->getTitle(),
					'url' => $page->getUrl(),
					'content' => $page->getContent(),
					'meta' => $meta,
					'date' => $meta['date']
					);
			}

			function build_sorter($key) {
				return function ($a, $b) use ($key) {
					return strnatcmp($b[$key], $a[$key]);
				};
			}

			usort($this->config['pages'], build_sorter($this->settings['post_key']));
			// set the appropriate headers to RSS feeds
			header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
			header("Content-Type: application/rss+xml; charset=UTF-8");
			// echo out the template file
			echo $this->render_file('template.php', $this->config);
			// exit the app and stop all activity
			exit;
		}
	}
}
