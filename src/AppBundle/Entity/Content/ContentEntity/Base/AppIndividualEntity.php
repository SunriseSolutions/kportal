<?php

namespace AppBundle\Entity\Content\ContentEntity\Base;

use AppBundle\Entity\Content\NodeType\Blog\BlogItem;
use AppBundle\Entity\Content\ContentEntity\ContentEntity;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

abstract class AppIndividualEntity extends ContentEntity {
	
	function __construct() {
		parent::__construct();
	}
	
	public function getName() {
		return $this->owner->getFirstname() . ' ' . $this->owner->getLastname();
	}
	
	/**
	 * @var User
	 */
	protected $owner;
	
	/**
	 * @return User
	 */
	public function getOwner() {
		return $this->owner;
	}
	
	/**
	 * @param User $owner
	 */
	public function setOwner($owner) {
		$this->owner = $owner;
	}
	
	
}