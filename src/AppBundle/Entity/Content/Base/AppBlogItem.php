<?php

namespace AppBundle\Entity\Content\Base;

use AppBundle\Entity\Content\ArticleNode;
use AppBundle\Entity\Content\BlogNode;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppBlogItem {
	
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * @var BlogNode
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\BlogNode",inversedBy="items")
	 * @ORM\JoinColumn(name="id_blog", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $blog;
	
	/**
	 * @var ArticleNode
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\ArticleNode",inversedBy="blogItems")
	 * @ORM\JoinColumn(name="id_article", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $article;
	
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
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 *
	 */
	protected $position = 0;
	
	/**
	 * @return BlogNode
	 */
	public function getBlog() {
		return $this->blog;
	}
	
	/**
	 * @param BlogNode $blog
	 */
	public function setBlog($blog) {
		$this->blog = $blog;
	}
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
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
	 * @return ArticleNode
	 */
	public function getArticle() {
		return $this->article;
	}
	
	/**
	 * @param ArticleNode $article
	 */
	public function setArticle($article) {
		$this->article = $article;
	}
}