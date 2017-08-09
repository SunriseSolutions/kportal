<?php

namespace AppBundle\Entity\Content\ContentEntity\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppContentEntity {
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
		$this->contentNodes = new ArrayCollection();
	}
	
	public abstract function getName();
	
	protected $owner;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\ContentNode", mappedBy="owner", cascade={"persist","merge"})
	 */
	protected $contentNodes;
	
	public function addContentNode(ContentNode $poc) {
		$this->contentNodes->add($poc);
		$poc->setOwner($this);
	}
	
	public function removeContentNode(ContentNode $poc) {
		$this->contentNodes->removeElement($poc);
		$poc->setOwner(null);
	}
	
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $enabled = true;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=128, nullable=true)
	 */
	protected $slug;
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getContentNodes() {
		return $this->contentNodes;
	}
	
	/**
	 * @param ArrayCollection $contentNodes
	 */
	public function setContentNodes($contentNodes) {
		$this->contentNodes = $contentNodes;
	}
	
	
	/**
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}
	
	/**
	 * @param string $slug
	 */
	public function setSlug($slug) {
		$this->slug = $slug;
	}
	
	/**
	 * @return mixed
	 */
	public function getOwner() {
		return $this->owner;
	}
	
	/**
	 * @param mixed $owner
	 */
	public function setOwner($owner) {
		$this->owner = $owner;
	}
	
	/**
	 * @return bool
	 */
	public function isEnabled() {
		return $this->enabled;
	}
	
	/**
	 * @param bool $enabled
	 */
	public function setEnabled($enabled) {
		$this->enabled = $enabled;
	}
}