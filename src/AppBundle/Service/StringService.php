<?php

namespace AppBundle\Service;


class StringService {
	
	/**
	 * @param $content
	 * @param $start
	 * @param $end
	 *
	 * @return string
	$code = '[include file="header.html"]';
	 * $innerCode = GetBetween($code, '[', ']');
	 * $innerCodeParts = explode(' ', $innerCode);
	 *
	 * $command = $innerCodeParts[0];
	 *
	 * $attributeAndValue = $innerCodeParts[1];
	 * $attributeParts = explode('=', $attributeParts);
	 * $attribute = $attributeParts[0];
	 * $attributeValue = str_replace('\"', '', $attributeParts[1]);
	 *
	 * echo $command . ' ' . $attribute . '=' . $attributeValue;
	 * //this will result in include file=header.html
	 * $command will be "include"
	 *
	 * $attribute will be "file"
	 *
	 * $attributeValue will be "header.html"
	 */
	public function getBetween($content, $start, $end) {
		$r = explode($start, $content);
		if(isset($r[1])) {
			$r = explode($end, $r[1]);
			
			return trim($r[0]);
		}
		
		return '';
	}
	
	public function parseShortCode($content, $shortcode) {
		$innerCode   = $this->getBetween($content, '[' . $shortcode, ']');
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
}