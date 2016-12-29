<?php
/**
 * Plugin class
 */
namespace Phile\Plugin\Phile\TwigFilters;

/**
 * An example plugin showing how to make Twig filters
 * usage {{ content|excerpt }}
 */
class Plugin extends \Phile\Plugin\AbstractPlugin implements \Phile\Gateway\EventObserverInterface {
	/**
	 * the constructor
	 */
	public function __construct() {
		\Phile\Event::registerEvent('template_engine_registered', $this);
	}

	/**
	 * event method
	 *
	 * @param string $eventKey
	 * @param null   $data
	 *
	 * @return mixed|void
	 */
	public function on($eventKey, $data = null) {
		if ($eventKey == 'template_engine_registered') {
			// grab the first paragraph and remove all the html code
			$excerpt = new \Twig_SimpleFilter('excerpt', function ($string){
				return strip_tags(substr($string, 0, strpos($string, "</p>") + 4));
			});
			$data['engine']->addFilter($excerpt);
			// limit words function -- very rough limit due to HTML input
			$limit_words = new \Twig_SimpleFilter('limit_words', function ($string) {
				$words = str_word_count($string, 2);
				$nbwords = count($words);
				$pos = array_keys($words);
				if ($this->settings['limit'] >= $nbwords) {
					return trim($string);
				}
				else {
					return trim(substr($string, 0, $pos[$this->settings['limit']])) . '...';
				}
			});
			$data['engine']->addFilter($limit_words);
		}
	}
}
