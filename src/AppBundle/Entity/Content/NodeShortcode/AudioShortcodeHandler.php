<?php

namespace AppBundle\Entity\Content\NodeShortcode;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;

class AudioShortcodeHandler extends AbstractShortcodeHandler {
	
	public function process($content, $escaped = false) {
		$container      = $this->container;
		$stringService  = $container->get('app.string');
		$h5pService     = $container->get('app.h5p');
		$h5pContentRepo = $container->get('doctrine')->getRepository(Content::class);
		$shortcodeCount = 0;
		
		$h5pIds = [];
		while( ! empty($shortcodeData = $this->parseShortCode($content, 'audio', $escaped))) {
			$shortcodeCount ++;
			
			$htmlReplaceFormat = '<span class="btn btn-default playAudioOnClick" data-audioalias="%1$s">%2$s</span>';
			if( ! empty($shortcodeData)) {
				$htmlReplace = sprintf($htmlReplaceFormat, $shortcodeData['attributes']['id'], $shortcodeData['attributes']['label']);
				$content     = str_replace($shortcodeData['tag'], $htmlReplace, $content);
			}
			
		}
		
		return [ 'content' => $content ];
	}
}