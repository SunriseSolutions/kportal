<?php

namespace AppBundle\Doctrine\ORM\Listener\Content;

use AppBundle\Entity\Content\ContentNode;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContentNodeListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateProperties(ContentNode $object) {
		$request     = $this->container->get('request_stack')->getCurrentRequest();
		$siteService = $this->container->get('app.site');
		$router      = $this->container->get('router');
		$trans       = $this->container->get('translator');
		if(empty($object->getRootTopic())) {
			$hostParams = $siteService->getHostParams();
			if(array_key_exists('topic', $hostParams)) {
				$object->setRootTopic($hostParams['topic']);
			}
		}
	}
	
	public function prePersistHandler(ContentNode $object, LifecycleEventArgs $event) {
		$this->updateProperties($object);
	}
	
	
	public function preUpdateHandler(ContentNode $object, LifecycleEventArgs $event) {
		$this->updateProperties($object);
	}
	
	public function postUpdateHandler(ContentNode $object, LifecycleEventArgs $event) {
		
	}
	
	public function preRemoveHandler(ContentNode $object, LifecycleEventArgs $event) {
		
	}
	
	public function postRemoveHandler(ContentNode $object, LifecycleEventArgs $event) {
	
	}
	
	public function postPersistHandler(ContentNode $employer, LifecycleEventArgs $event) {
	
	
	}
}