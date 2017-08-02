<?php

namespace AppBundle\Entity\Content\NodeLayout\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\GenericLayout;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppRootLayout {
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
		$this->children = new ArrayCollection();
	}
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeLayout\GenericLayout", mappedBy="root", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $children;
	
	public function addChild(GenericLayout $layout) {
		$this->children->add($layout);
		$layout->setRoot($this);
	}
	
	public function removeChild(GenericLayout $layout) {
		$this->children->remove($layout);
		$layout->setRoot(null);
	}
	
	/**
	 * @var ContentNode
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Content\ContentNode", inversedBy="layout")
	 * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="CASCADE"))
	 */
	protected $node;
	
	/**
	 * @return ArrayCollection
	 */
	public function getChildren() {
		return $this->children;
	}
	
	/**
	 * @param ArrayCollection $children
	 */
	public function setChildren($children) {
		$this->children = $children;
	}
	
	/**
	 * @return ContentNode
	 */
	public function getNode() {
		return $this->node;
	}
	
	/**
	 * @param ContentNode $node
	 */
	public function setNode($node) {
		$this->node = $node;
	}
	
}