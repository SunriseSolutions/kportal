<?php

namespace AppBundle\Doctrine\ORM\Listener\H5P;

use AppBundle\Entity\H5P\Content;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContentListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateParameters(Content $object) {
		$param = $object->buildParameterObject();
		
		$object->setParameters(json_encode($param, JSON_UNESCAPED_SLASHES));
		$object->setFiltered(json_encode($param));
	}
	
	public function prePersistHandler(Content $object, LifecycleEventArgs $event) {
		$this->updateParameters($object);
		if(empty($object->getSlug())) {
			$object->setSlug(Slugify::create()->slugify($object->getTitle()));
		}
		if(empty($object->getKeywords())) {
			$object->setKeywords($object->getTitle());
		}
	}
	
	
	public function preUpdateHandler(Content $object, LifecycleEventArgs $event) {
		$this->updateParameters($object);
	}
	
	public function postUpdateHandler(Content $object, LifecycleEventArgs $event) {
		
	}
	
	public function preRemoveHandler(Content $object, LifecycleEventArgs $event) {
		
	}
	
	public function postRemoveHandler(Content $object, LifecycleEventArgs $event) {
	
	}
	
	public function postPersistHandler(Content $employer, LifecycleEventArgs $event) {
	
	
	}
}