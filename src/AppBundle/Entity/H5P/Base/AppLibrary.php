<?php

namespace AppBundle\Entity\H5P\Base;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\Dependency;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass
 */
class AppLibrary {
	/**
	 * @var int $id
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
		$this->createdAt = new \DateTime();
		
		$this->contentNodes = new ArrayCollection();
		$this->dependees = new ArrayCollection();
		$this->dependencies = new ArrayCollection();
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\Content", mappedBy="library", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $contentNodes;
	
	public function addContentNode(Content $node) {
		$this->contentNodes->add($node);
		$node->setLibrary($this);
	}
	
	public function removeContentNode(Content $node) {
		$this->dependencies->removeElement($node);
		$node->setLibrary(null);
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\Dependency", mappedBy="dependee", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $dependencies;
	
	public function addDependency(Dependency $dependency) {
		$this->dependencies->add($dependency);
		$dependency->setDependee($this);
	}
	
	public function removeDependency(Dependency $dependency) {
		$this->dependencies->removeElement($dependency);
		$dependency->setDependee(null);
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\Dependency", mappedBy="dependency", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $dependees;
	
	public function addDependee(Dependency $dependee) {
		$this->dependees->add($dependee);
		$dependee->setDependency($this);
	}
	
	public function removeDependee(Dependency $dependee) {
		$this->dependees->removeElement($dependee);
		$dependee->setDependency(null);
	}
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", options={"default": 0})
	 */
	protected $createdAt;
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $updatedAt;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=127)
	 */
	protected $machineName;
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $title;
	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	protected $majorVersion;
	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	protected $minorVersion;
	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	protected $patchVersion;
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $runnable = false;
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $restricted = false;
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $fullscreen = false;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $embedTypes;
	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $preloadedJs;
	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $preloadedCss;
	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $dropLibraryCss;
	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $semantics;
	/**
	 * @var string
	 * @ORM\Column(type="string", length=1023)
	 */
	protected $tutorialUrl;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $iconIncluded = false;
	
	/**
	 * @return ArrayCollection
	 */
	public function getDependencies() {
		return $this->dependencies;
	}
	
	/**
	 * @param ArrayCollection $dependencies
	 */
	public function setDependencies($dependencies) {
		$this->dependencies = $dependencies;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getDependees() {
		return $this->dependees;
	}
	
	/**
	 * @param ArrayCollection $dependees
	 */
	public function setDependees($dependees) {
		$this->dependees = $dependees;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	/**
	 * @param \DateTime $updatedAt
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
	}
	
	/**
	 * @return string
	 */
	public function getMachineName() {
		return $this->machineName;
	}
	
	/**
	 * @param string $machineName
	 */
	public function setMachineName($machineName) {
		$this->machineName = $machineName;
	}
	
	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}
	
	/**
	 * @return int
	 */
	public function getMajorVersion() {
		return $this->majorVersion;
	}
	
	/**
	 * @param int $majorVersion
	 */
	public function setMajorVersion($majorVersion) {
		$this->majorVersion = $majorVersion;
	}
	
	/**
	 * @return int
	 */
	public function getMinorVersion() {
		return $this->minorVersion;
	}
	
	/**
	 * @param int $minorVersion
	 */
	public function setMinorVersion($minorVersion) {
		$this->minorVersion = $minorVersion;
	}
	
	/**
	 * @return int
	 */
	public function getPatchVersion() {
		return $this->patchVersion;
	}
	
	/**
	 * @param int $patchVersion
	 */
	public function setPatchVersion($patchVersion) {
		$this->patchVersion = $patchVersion;
	}
	
	/**
	 * @return bool
	 */
	public function isRunnable() {
		return $this->runnable;
	}
	
	/**
	 * @param bool $runnable
	 */
	public function setRunnable($runnable) {
		$this->runnable = $runnable;
	}
	
	/**
	 * @return bool
	 */
	public function isRestricted() {
		return $this->restricted;
	}
	
	/**
	 * @param bool $restricted
	 */
	public function setRestricted($restricted) {
		$this->restricted = $restricted;
	}
	
	/**
	 * @return bool
	 */
	public function isFullscreen() {
		return $this->fullscreen;
	}
	
	/**
	 * @param bool $fullscreen
	 */
	public function setFullscreen($fullscreen) {
		$this->fullscreen = $fullscreen;
	}
	
	/**
	 * @return string
	 */
	public function getEmbedTypes() {
		return $this->embedTypes;
	}
	
	/**
	 * @param string $embedTypes
	 */
	public function setEmbedTypes($embedTypes) {
		$this->embedTypes = $embedTypes;
	}
	
	/**
	 * @return string
	 */
	public function getPreloadedJs() {
		return $this->preloadedJs;
	}
	
	/**
	 * @param string $preloadedJs
	 */
	public function setPreloadedJs($preloadedJs) {
		$this->preloadedJs = $preloadedJs;
	}
	
	/**
	 * @return string
	 */
	public function getPreloadedCss() {
		return $this->preloadedCss;
	}
	
	/**
	 * @param string $preloadedCss
	 */
	public function setPreloadedCss($preloadedCss) {
		$this->preloadedCss = $preloadedCss;
	}
	
	/**
	 * @return string
	 */
	public function getDropLibraryCss() {
		return $this->dropLibraryCss;
	}
	
	/**
	 * @param string $dropLibraryCss
	 */
	public function setDropLibraryCss($dropLibraryCss) {
		$this->dropLibraryCss = $dropLibraryCss;
	}
	
	/**
	 * @return string
	 */
	public function getSemantics() {
		return $this->semantics;
	}
	
	/**
	 * @param string $semantics
	 */
	public function setSemantics($semantics) {
		$this->semantics = $semantics;
	}
	
	/**
	 * @return string
	 */
	public function getTutorialUrl() {
		return $this->tutorialUrl;
	}
	
	/**
	 * @param string $tutorialUrl
	 */
	public function setTutorialUrl($tutorialUrl) {
		$this->tutorialUrl = $tutorialUrl;
	}
	
	/**
	 * @return bool
	 */
	public function isIconIncluded() {
		return $this->iconIncluded;
	}
	
	/**
	 * @param bool $iconIncluded
	 */
	public function setIconIncluded($iconIncluded) {
		$this->iconIncluded = $iconIncluded;
	}
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
}