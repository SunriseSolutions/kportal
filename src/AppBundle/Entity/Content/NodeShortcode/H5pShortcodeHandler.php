<?php

namespace AppBundle\Entity\Content\NodeShortcode;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;

class H5pShortcodeHandler extends AbstractShortcodeHandler {
	
	const PROPERTY_H5PIDS = 'h5pIds';
	
	public function process($content, $escaped = false) {
		$container      = $this->container;
		$stringService  = $container->get('app.string');
		$h5pService     = $container->get('app.h5p');
		$h5pContentRepo = $container->get('doctrine')->getRepository(Content::class);
		$shortcodeCount = 0;
		
		$h5pIds = [];
		while( ! empty($shortcodeData = $this->parseShortCode($content, 'h5p'))) {
			$shortcodeCount ++;
			/** @var Content $h5pContent */
			$h5pContent = $h5pContentRepo->find($shortcodeData['attributes']['id']);
			if( ! empty($h5pContent)) {
				$embed      = $h5pService->getContentActualEmbedType($h5pContent);
				$hideOnLoad = $embed === 'div';
				if($h5pContent instanceof ContentMultiChoice) {
					if( ! empty($media = $h5pContent->getMultichoiceMedia())) {
						if($media->isYoutube()) {
							$hideOnLoad &= false;
						}
					}
				}
				$htmlReplaceFormat = '<button data-h5ptarget="%1$d" class="btn-content btn btn-default">%2$s</button> <br/> ' . $h5pService->getContentHtml($h5pContent, [
						'class' => $hideOnLoad ? 'hidden' : 'h5p-app-active',
						'id'    => 'h5p_%1$d'
					]);
				if( ! empty($shortcodeData)) {
					$htmlReplace                                  = sprintf($htmlReplaceFormat, $shortcodeCount, $shortcodeData['attributes']['label']);
					$content                                      = str_replace($shortcodeData['tag'], $htmlReplace, $content);
					$h5pIds[ $shortcodeData['attributes']['id'] ] = null;
				}
			} else {
				$content = str_replace($shortcodeData['tag'], '', $content);
			}
		}
		
		return [ 'content' => $content, 'h5pIds' => $h5pIds ];
	}
}