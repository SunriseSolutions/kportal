<?php

namespace AppBundle\Entity\H5P\Base;

use AppBundle\Entity\H5P\Dependency;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
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
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\Base\AppDependency", mappedBy="dependee", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $dependencies;
	
	public function addDependency(Dependency $dependency)
	{
		$this->dependencies->add($dependency);
		$dependency->setDependee($this);
	}
	
	public function removeDependency(Dependency $dependency)
	{
		$this->dependencies->removeElement($dependency);
		$dependency->setDependee(null);
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\Base\AppDependency", mappedBy="dependency", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $dependees;
	
	public function addDependee(Dependency $dependee)
	{
		$this->dependees->add($dependee);
		$dependee->setDependency($this);
	}
	
	public function removeDependee(Dependency $dependee)
	{
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
	
}