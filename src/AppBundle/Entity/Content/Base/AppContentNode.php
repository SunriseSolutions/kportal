<?php

namespace AppBundle\Entity\Content\Base;

use AppBundle\Entity\Content\ContentEntity;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppContentNode {
	
	function __construct() {
		$this->createdAt = new \DateTime();
	}
	
	public function getAbstractContent() {
		if( ! empty($this->abstract)) {
			return $this->abstract;
		}
		
		return '<p>' . substr(strip_tags($this->getHtmlBody()), 0, 255) . '... </p>';
	}
	
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	/**
	 * @var array
	 * @ORM\Column(type="attribute_array", nullable=true)
	 */
	protected $h5pContent;
	
	/**
	 * @var ContentEntity
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\ContentEntity",inversedBy="contentNodes")
	 * @ORM\JoinColumn(name="id_owner", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $owner;
	
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
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $container = false;
	
	/**
	 * @var string
	 * @ORM\Column(type="string",length=255, nullable=true)
	 */
	protected $abstract;
	
	/**
	 * ID_REF
	 * @var string
	 * @ORM\Column(type="string", length=24, nullable=true)
	 */
	protected $topic;
	
	/**
	 * ID_REF
	 * @var string
	 * @ORM\Column(type="string", length=24, nullable=true)
	 */
	protected $rootTopic;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=128, nullable=true)
	 */
	protected $slug;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=256, nullable=true)
	 */
	protected $publicUrl;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=2, options={"default":"en"} ,  nullable=true)
	 */
	protected $locale = 'en';
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $title;
	
	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $body;
	
	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $htmlBody;
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getTopic() {
		return $this->topic;
	}
	
	/**
	 * @param string $topic
	 */
	public function setTopic($topic) {
		$this->topic = $topic;
	}
	
	/**
	 * @return string
	 */
	public function getLocale() {
		return $this->locale;
	}
	
	/**
	 * @param string $locale
	 */
	public function setLocale($locale) {
		$this->locale = $locale;
	}
	
	/**
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}
	
	/**
	 * @param string $body
	 */
	public function setBody($body) {
		$this->body = $body;
	}
	
	/**
	 * @return string
	 */
	public function getRootTopic() {
		return $this->rootTopic;
	}
	
	/**
	 * @param string $rootTopic
	 */
	public function setRootTopic($rootTopic) {
		$this->rootTopic = $rootTopic;
	}
	
	/**
	 * @return bool
	 */
	public function isContainer() {
		return $this->container;
	}
	
	/**
	 * @param bool $container
	 */
	public function setContainer($container) {
		$this->container = $container;
	}
	
	/**
	 * @return AppContentEntity
	 */
	public function getOwner() {
		return $this->owner;
	}
	
	/**
	 * @param AppContentEntity $owner
	 */
	public function setOwner($owner) {
		$this->owner = $owner;
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
	public function getHtmlBody() {
		return $this->htmlBody;
	}
	
	/**
	 * @param string $htmlBody
	 */
	public function setHtmlBody($htmlBody) {
		$this->htmlBody = $htmlBody;
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
	public function getPublicUrl() {
		return $this->publicUrl;
	}
	
	/**
	 * @param string $publicUrl
	 */
	public function setPublicUrl($publicUrl) {
		$this->publicUrl = $publicUrl;
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
	public function getAbstract() {
		return $this->abstract;
	}
	
	/**
	 * @param string $abstract
	 */
	public function setAbstract($abstract) {
		$this->abstract = $abstract;
	}
	
	/**
	 * @return array
	 */
	public function getH5pContent() {
		return $this->h5pContent;
	}
	
	/**
	 * @param array $h5pContent
	 */
	public function setH5pContent($h5pContent) {
		$this->h5pContent = $h5pContent;
	}
	
}