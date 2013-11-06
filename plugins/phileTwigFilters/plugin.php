<?php

/**
 * Class PhileDemoPlugin <= the class name is the pluginKey but first char uppercase!
 * important: the pluginKey is also the folder name!
 */
class PhileTwigFilters extends \Phile\Plugin\AbstractPlugin implements \Phile\EventObserverInterface {
	public function __construct() {
		\Phile\Event::registerEvent('template_engine_registered', $this);
	}

	public function on($eventKey, $data = null) {
		if ($eventKey == 'template_engine_registered') {
			$filter = new Twig_SimpleFilter('first_paragraph', function ($string){
				// grab the first paragraph and now remove all the html code
				return strip_tags(substr($string, 0, strpos($string, "</p>") + 4));
			});
			$data['engine']->addFilter($filter);
		}
	}
}
