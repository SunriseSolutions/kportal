<?php

namespace AppBundle\Entity\Content\NodeShortcode;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractShortcodeHandler {
	public abstract function process($content, $escaped = false);
	
	/**
	 * @var ContainerInterface
	 */
	protected $container;
	
	public function parseShortCode($content, $shortcode) {
		$innerCode   = $this->container->get('app.string')->getBetween($content, '[' . $shortcode, ']');
		$openTagPos  = strpos($content, '[' . $shortcode);
		$closeTagPos = strpos($content, ']', $openTagPos);
		
		$shortcodeData = [];
		
		if($closeTagPos > $openTagPos && $openTagPos > - 1) {
			$tag                  = trim(substr($content, $openTagPos, $closeTagPos - $openTagPos + 1));
			$shortcodeData['tag'] = $tag;
			
			$lastPos                     = 0;
			$shortcodeData['attributes'] = [];
			
			while(($equalSignPos = strpos($innerCode, '=', $lastPos)) > - 1) {
				$key = trim(substr($innerCode, $lastPos, $equalSignPos - $lastPos));
				
				$openQuotePos  = strpos($innerCode, '&quot;', $equalSignPos) + 6;
				$closeQuotePos = strpos($innerCode, '&quot;', $openQuotePos);
				
				$value = substr($innerCode, $openQuotePos, $closeQuotePos - $openQuotePos);
				
				$lastPos = $closeQuotePos + 6;

//			$attribute                = [ $key => $value ];
				$shortcodeData['attributes'][ $key ] = $value;
			}
			
		}

//		$innerCodeParts = explode(' ', $innerCode);

//		foreach($innerCodeParts as $innerCodePart) {
//			$attributeAndValue           = $innerCodePart;
//			$attributePart               = explode('=', $attributeAndValue);
//			$attributeKey                = $attributePart[0];
//			$attributeValue              = str_replace('\"', '', $attributePart[1]);
//			$attributes[ $attributeKey ] = $attributeValue;
//		}
		
		return $shortcodeData;
	}
	
	/**
	 * @return ContainerInterface
	 */
	public function getContainer() {
		return $this->container;
	}
	
	/**
	 * @param ContainerInterface $container
	 */
	public function setContainer($container) {
		$this->container = $container;
	}
	
}