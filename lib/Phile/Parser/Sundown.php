<?php
namespace Phile\Parser;

class Sundown implements ParserInterface {
	private $config;

	public function __construct($config = null)
	{
		if (is_null($config)) {
			$this->config = array(
				'fenced_code_blocks' => true,
				'tables' => false,
				'autolink' => true,
				'space_after_headers' => false,
				'lax_html_blocks' => true
				);
		} else {
			$this->config = $config;
		}
	}
	// overload the Markdown parse with the Sundown parser
	public function parse($data) {
		$sundown = new \Sundown\Markdown(\Sundown\Render\HTML, $this->config);
		return $sundown->render($data);
	}
}
