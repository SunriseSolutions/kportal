<?php

namespace AppBundle\Entity\Content\NodeLayout\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\GenericLayout;
use AppBundle\Entity\Content\NodeLayout\RootLayout;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppGenericLayout {
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
	 * @var RootLayout
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\RootLayout")
	 * @ORM\JoinColumn(name="id_root_container", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $rootContainer;
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @var RootLayout
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\RootLayout",inversedBy="children")
	 * @ORM\JoinColumn(name="id_root", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $root;
	
	/**
	 * @var GenericLayout
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\GenericLayout",inversedBy="children")
	 * @ORM\JoinColumn(name="id_parent", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $parent;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeLayout\GenericLayout", mappedBy="parent", cascade={"persist","merge"}, orphanRemoval=true)
	 * @ORM\OrderBy({"position" = "ASC"})
	 */
	protected $children;
	
	public function addChild(GenericLayout $layout) {
		$this->children->add($layout);
		$layout->setParent($this);
	}
	
	public function removeChild(GenericLayout $layout) {
		$this->children->remove($layout);
		$layout->setParent(null);
	}
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer", options={"default":0})
	 */
	protected $position = 0;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $name;
	
	/**
	 * @return RootLayout
	 */
	public function getRoot() {
		return $this->root;
	}
	
	/**
	 * @param RootLayout $root
	 */
	public function setRoot($root) {
		$this->root = $root;
	}
	
	/**
	 * @return GenericLayout
	 */
	public function getParent() {
		return $this->parent;
	}
	
	/**
	 * @param GenericLayout $parent
	 */
	public function setParent($parent) {
		$this->parent = $parent;
	}
	
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
	 * @return int
	 */
	public function getPosition() {
		return $this->position;
	}
	
	/**
	 * @param int $position
	 */
	public function setPosition($position) {
		$this->position = $position;
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @return RootLayout
	 */
	public function getRootContainer() {
		return $this->rootContainer;
	}
	
	/**
	 * @param RootLayout $rootContainer
	 */
	public function setRootContainer($rootContainer) {
		$this->rootContainer = $rootContainer;
	}
	
}