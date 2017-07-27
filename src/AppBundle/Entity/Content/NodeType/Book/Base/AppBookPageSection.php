<?php

namespace AppBundle\Entity\Content\NodeType\Book\Base;

use AppBundle\Entity\Content\NodeType\Article\ArticleNode;
use AppBundle\Entity\Content\NodeType\Blog\BlogNode;
use AppBundle\Entity\Content\NodeType\Book\BookNode;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppBookPageSection {
	
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
 	}
	
	/**
	 * @var BookNode
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeType\Book\BookPage",inversedBy="sections")
	 * @ORM\JoinColumn(name="id_book", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $page;
	
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
	 * @return BookNode
	 */
	public function getPage() {
		return $this->page;
	}
	
	/**
	 * @param BookNode $page
	 */
	public function setPage($page) {
		$this->page = $page;
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
	
	
}