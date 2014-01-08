<?php

/**
 * Phile RSS Feed Plugin
 * converted from https://github.com/gilbitron/Pico-RSS-Plugin
 */
class PhileRSSFeed extends \Phile\Plugin\AbstractPlugin implements \Phile\EventObserverInterface {

	private $config;

	public function __construct() {
		\Phile\Event::registerEvent('plugins_loaded', $this);
		$this->config = \Phile\Registry::get('Phile_Settings');
	}

	// this is a simple function to render a PHP file based on an input array
	private function render_file($filename, $vars = null) {
		if (is_array($vars) && !empty($vars)) {
			extract($vars);
		}
		ob_start();
		include \Phile\Utility::resolveFilePath("MOD:phileRSSFeed/".$filename);
		return ob_get_clean();
	}

	public function on($eventKey, $data = null) {
		// check $eventKey for which you have registered
		if ($eventKey == 'plugins_loaded') {
			$uri = str_replace('/' . \Phile\Utility::getInstallPath(), '', $_SERVER['REQUEST_URI']);
			if ($uri == $this->settings['feed_url']) {
				$pageRespository = new \Phile\Repository\Page();
				$pages = $pageRespository->findAll();
				// merge the arrays to bind the settings to the view
				$this->config = array_merge($this->config, $this->settings);
				$this->config['pages'] = array();
				// convert the pages into key => values and not an object
				for ($i=0; $i < count($pages); $i++) {
					$this->config['pages'][] = array(
						'title' => $pages[$i]->getTitle(),
						'url' => $pages[$i]->getUrl(),
						'content' => $pages[$i]->getContent(),
						'meta' => $pages[$i]->getMeta(),
						'date' => $pages[$i]->getMeta()['date']
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
}
