<?php

namespace AppBundle\Entity\H5P\Base;

use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppDependency {
	
	const TYPE_PRELOADED = 'preloaded';
	
	
	function __construct() {
		$this->dependencyType = 'preloaded';
	}
	
	
	/**
	 * @var Library
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\H5P\Library",inversedBy="dependees")
	 * @ORM\JoinColumn(name="id_dependency", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $dependency;
	
	/**
	 * @var Library
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\H5P\Library",inversedBy="dependencies")
	 * @ORM\JoinColumn(name="id_dependee", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $dependee;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=31, options={"default":"preloaded"})
	 */
	protected $dependencyType;
	
	/**
	 * @return Library
	 */
	public function getDependency() {
		return $this->dependency;
	}
	
	/**
	 * @param Library $dependency
	 */
	public function setDependency($dependency) {
		$this->dependency = $dependency;
	}
	
	/**
	 * @return Library
	 */
	public function getDependee() {
		return $this->dependee;
	}
	
	/**
	 * @param Library $dependee
	 */
	public function setDependee($dependee) {
		$this->dependee = $dependee;
	}
	
	/**
	 * @return string
	 */
	public function getDependencyType() {
		return $this->dependencyType;
	}
	
	/**
	 * @param string $dependencyType
	 */
	public function setDependencyType($dependencyType) {
		$this->dependencyType = $dependencyType;
	}
	
	
	
}