<?php

namespace AppBundle\Doctrine\ORM\Listener\Content\ContentPiece;

use AppBundle\Entity\Content\ContentPiece\ContentPiece;
use AppBundle\Entity\Content\ContentPiece\ContentPieceVocabEntry;
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
		$router     = $this->container->get('router');
		$trans      = $this->container->get('translator');
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
			$html             = '<button data-html="true" type="button" class="vocab-entry-popover btn btn-default" data-container="body" data-toggle="popover" data-placement="auto top" data-title="%2$s" data-content="%3$s">%1$s</button>';
			$entry            = $vocabEntry->getEntry();
			$translationEntry = $entry->getTranslation($request->getLocale());
			$actionButtonHtml = "";
			if( ! empty($entryAudio = $entry->getAudio())) {
				$actionButtonHtml .= "<span class='vocab-entry-popover-audio btn btn-primary' data-audioalias='" . $entryAudio->getId() . "'>  <i class='fa fa-volume-up' aria-hidden='true'> " . ($entry->getPhoneticSymbols() ?: '') . " </i> </span>";
//				$mediaUrl            = $fileServerUrl . '/file.php?f=' . $mediaIdExt;
				$actionButtonHtml .= "   ";
			}
			$actionButtonHtml .= "<a class='btn btn-info' href='" . $router->generate('entry_detail', [ 'entry' => $entry->getId() ]) . "' target='_blank'>" . $trans->trans('page.detail') . "</a>";
			
			if( ! empty($translationEntry)) {
				$content = str_replace($phrase = $entry->getPhrase(), sprintf($html, $phrase, $translationEntry->getPhrase(), $actionButtonHtml), $object->getContent());
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