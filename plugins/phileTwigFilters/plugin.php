<?php

/**
 * Class PhileDemoPlugin <= the class name is the pluginKey but first char uppercase!
 * important: the pluginKey is also the folder name!
 */
class PhileTwigFilters extends \Phile\Plugin\AbstractPlugin implements \Phile\EventObserverInterface {
	public function __construct() {
		\Phile\Event::registerEvent('before_render', $this);
	}

	public function on($eventKey, $data = null) {
		if ($eventKey == 'before_render') {
			$filter = new Twig_SimpleFilter('first_paragraph', function ($string){
				// grab the first paragraph
				// now remove all the html code
				return strip_tags(substr($string, 0, strpos($string, "</p>") + 4));
			});
			$data['twig']->addFilter($filter);
		}
	}
}