<?php

namespace AppBundle\Entity\H5P\Base;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\Dependency;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppContentLibrary {
	
	function __construct() {
	}
	
	/**
	 * @var Library
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\H5P\Library",inversedBy="contentLibraries")
	 * @ORM\JoinColumn(name="id_library", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $library;
	
	/**
	 * @var Content
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\H5P\Content",inversedBy="contentLibraries")
	 * @ORM\JoinColumn(name="id_content", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $content;
	
	/**
	 * @var string
	 * @ORM\Id
	 * @ORM\Column(type="string", length=31, options={"default":"preloaded"})
	 */
	protected $dependencyType = Dependency::TYPE_PRELOADED;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean",name="drop_css", options={"default":false})
	 */
	protected $dropCSS = false;
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer")
	 */
	protected $position;
	
	/**
	 * @return Library
	 */
	public function getLibrary() {
		return $this->library;
	}
	
	/**
	 * @param Library $library
	 */
	public function setLibrary($library) {
		$this->library = $library;
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
	
	/**
	 * @return Content
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 * @param Content $content
	 */
	public function setContent($content) {
		$this->content = $content;
	}
	
	/**
	 * @return bool
	 */
	public function isDropCSS() {
		return $this->dropCSS;
	}
	
	/**
	 * @param bool $dropCSS
	 */
	public function setDropCSS($dropCSS) {
		$this->dropCSS = $dropCSS;
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
}