<?php

namespace AppBundle\Doctrine\ORM\Listener\Content\NodeLayout;

use AppBundle\Entity\Content\NodeLayout\ContentPiece;
use AppBundle\Entity\Content\NodeLayout\ContentPieceVocabEntry;
use AppBundle\Entity\Content\NodeShortcode\H5pShortcodeHandler;
use AppBundle\Entity\Content\NodeShortcode\ShortcodeFactory;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContentPieceListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateProperties(ContentPiece $object) {
		$request    = $this->container->get('request_stack')->getCurrentRequest();
		$shortcodes = $object->getShortcodes();
		$formatter  = $object->getFormatter();
		$escaped    = false;
		if($formatter === 'richhtml') {
			$escaped = true;
		}
		/** @var ShortcodeFactory $shortcodeFactory */
		$shortcodeFactory = $this->container->get('app.shortcode_factory');
		$results          = $shortcodeFactory->process($object->getContent(), $shortcodes, $escaped);
		$object->setContent(end($results)['content']);
		$object->setH5pContent($h5pIds = $shortcodeFactory::getResult($results, H5pShortcodeHandler::PROPERTY_H5PIDS));
		
		$vocabEntries = $object->getVocabEntries();
		/** @var ContentPieceVocabEntry $vocabEntry */
		foreach($vocabEntries as $vocabEntry) {
			$html             = '<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="right" data-content="%s">%s</button>';
			$entry            = $vocabEntry->getEntry();
			$translationEntry = $entry->getTranslation($request->getLocale());
			if( ! empty($translationEntry)) {
				$content = str_replace($phrase = $entry->getPhrase(), sprintf($html, $translationEntry->getPhrase(), $phrase), $object->getContent());
				$object->setContent($content);
			}
		}
		
	}
	
	public function prePersistHandler(ContentPiece $object, LifecycleEventArgs $event) {
		$this->updateProperties($object);
	}
	
	
	public function preUpdateHandler(ContentPiece $object, LifecycleEventArgs $event) {
		$this->updateProperties($object);
	}
	
	public function postUpdateHandler(ContentPiece $object, LifecycleEventArgs $event) {
		
	}
	
	public function preRemoveHandler(ContentPiece $object, LifecycleEventArgs $event) {
		
	}
	
	public function postRemoveHandler(ContentPiece $object, LifecycleEventArgs $event) {
	
	}
	
	public function postPersistHandler(ContentPiece $employer, LifecycleEventArgs $event) {
	
	
	}
}