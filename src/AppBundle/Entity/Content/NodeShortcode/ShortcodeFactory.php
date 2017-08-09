<?php

namespace AppBundle\Entity\Content\NodeShortcode;


use Symfony\Component\DependencyInjection\ContainerInterface;

class ShortcodeFactory {
	
	public static $supportedShortcodes = array( 'h5p' => 'h5p', 'audio' => 'audio', 'playlist' => 'playlist' );
	
	public static $shortCodeHandlers = array();
	
	protected static $container;
	
	function __construct(ContainerInterface $container) {
		self::$container = $container;
	}
	
	public static function process($html, $shortcodes = array(), $escaped = false) {
		if(empty($shortcodes)) {
			$shortcodes = self::$supportedShortcodes;
		}
		$results = [];
		foreach($shortcodes as $shortcode) {
			if( ! array_key_exists($shortcode, self::$shortCodeHandlers)) {
				$shortCodeHandlerClass = __NAMESPACE__ . '\\' . ucfirst($shortcode) . 'ShortcodeHandler';
				/** @var AbstractShortcodeHandler $shortCodeHandler */
				$shortCodeHandler = new $shortCodeHandlerClass;
				$shortCodeHandler->setContainer(self::$container);
				self::$shortCodeHandlers[ $shortcode ] = $shortCodeHandler;
			} else {
				/** @var AbstractShortcodeHandler $shortCodeHandler */
				$shortCodeHandler = self::$shortCodeHandlers[ $shortcode ];
			}
			/** @var array $result */
			$result     = $shortCodeHandler->process($html, $escaped);
			$html       = $result['content'];
			$results [] = $result;
		}
		
		return $results;
	}
	
	public static function getResult($results = array(), $key) {
		/** @var array $result */
		foreach($results as $result) {
			if(array_key_exists($key, $result)) {
				return $result[ $key ];
			}
		}
	}
}