<?php

namespace AppBundle\Doctrine\ORM\Listener\Content\NodeLayout;

use AppBundle\Entity\Content\NodeLayout\ContentPiece;
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