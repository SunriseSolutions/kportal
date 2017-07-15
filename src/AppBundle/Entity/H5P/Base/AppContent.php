<?php

namespace AppBundle\Entity\H5P\Base;

use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass
 */
class AppContent {
	/**
	 * @var int $id
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
		$this->createdAt        = new \DateTime();
		$this->contentLibraries = new ArrayCollection();
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\ContentLibrary", mappedBy="content", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $contentLibraries;
	
	public function addContentLibrary(ContentLibrary $contentLibrary) {
		$this->contentLibraries->add($contentLibrary);
		$contentLibrary->setContent($this);
	}
	
	public function removeContentLibrary(ContentLibrary $contentLibrary) {
		$this->contentLibraries->removeElement($contentLibrary);
		$contentLibrary->setContent(null);
	}
	
	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User")
	 * @ORM\JoinColumn(name="id_user", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $owner;
	
	/**
	 * @var Library
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\H5P\Library",inversedBy="contentNodes")
	 * @ORM\JoinColumn(name="id_library", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $library;
	
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
	 * @var integer
	 * @ORM\Column(type="integer", options={"default":0} )
	 */
	protected $disable = 0;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $enabled = true;
	
	/**
	 * ID_REF
	 * @var string
	 * @ORM\Column(type="string", length=24, nullable=true)
	 */
	protected $topic;
	
	/**
	 * custom field
	 * @var string
	 * @ORM\Column(type="string", length=2, options={"default":"en"}, nullable=true )
	 */
	protected $locale = 'en';
	
	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $parameters;
	
	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $filtered;
	
	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $keywords;
	
	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $description;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $title;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=127)
	 */
	protected $slug;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=127)
	 */
	protected $embedType;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=127, nullable=true)
	 */
	protected $contentType;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=127, nullable=true)
	 */
	protected $author;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=7, nullable=true)
	 */
	protected $license;
	
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
	
	/**
	 * @return string
	 */
	public function getParameters() {
		return $this->parameters;
	}
	
	/**
	 * @param string $parameters
	 */
	public function setParameters($parameters) {
		$this->parameters = $parameters;
	}
	
	/**
	 * @return string
	 */
	public function getFiltered() {
		return $this->filtered;
	}
	
	/**
	 * @param string $filtered
	 */
	public function setFiltered($filtered) {
		$this->filtered = $filtered;
	}
	
	/**
	 * @return string
	 */
	public function getKeywords() {
		return $this->keywords;
	}
	
	/**
	 * @param string $keywords
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}
	
	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
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
	 * @return string
	 */
	public function getEmbedType() {
		return $this->embedType;
	}
	
	/**
	 * @param string $embedType
	 */
	public function setEmbedType($embedType) {
		$this->embedType = $embedType;
	}
	
	/**
	 * @return string
	 */
	public function getContentType() {
		return $this->contentType;
	}
	
	/**
	 * @param string $contentType
	 */
	public function setContentType($contentType) {
		$this->contentType = $contentType;
	}
	
	/**
	 * @return string
	 */
	public function getAuthor() {
		return $this->author;
	}
	
	/**
	 * @param string $author
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}
	
	/**
	 * @return string
	 */
	public function getLicense() {
		return $this->license;
	}
	
	/**
	 * @param string $license
	 */
	public function setLicense($license) {
		$this->license = $license;
	}
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getContentLibraries() {
		return $this->contentLibraries;
	}
	
	/**
	 * @param ArrayCollection $contentLibraries
	 */
	public function setContentLibraries($contentLibraries) {
		$this->contentLibraries = $contentLibraries;
	}
	
	/**
	 * @return mixed
	 */
	public function getDisable() {
		return $this->disable;
	}
	
	/**
	 * @param mixed $disable
	 */
	public function setDisable($disable) {
		$this->disable = $disable;
	}
	
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
	
	/**
	 * @return mixed
	 */
	public function getLocale() {
		return $this->locale;
	}
	
	/**
	 * @param mixed $locale
	 */
	public function setLocale($locale) {
		$this->locale = $locale;
	}
	
	/**
	 * @return mixed
	 */
	public function getTopic() {
		return $this->topic;
	}
	
	/**
	 * @param mixed $topic
	 */
	public function setTopic($topic) {
		$this->topic = $topic;
	}
}