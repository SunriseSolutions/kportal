<?php

namespace AppBundle\Entity\Content\NodeShortcode;


class ShortcodeFactory {
	
	private static $supportedShortcodes = array( 'h5p', 'html' );
	
	public static function process($html, $shortcodes = array()) {
		if(empty($shortcodes)) {
			$shortcodes = self::$supportedShortcodes;
		}
		foreach($shortcodes as $shortcode) {
			$shortcodeClass = __NAMESPACE__ . '\\' . ucfirst($shortcode) . 'Shortcode';
			$html           = $shortcodeClass::process($html);
		}
		
		return $html;
	}
	
}