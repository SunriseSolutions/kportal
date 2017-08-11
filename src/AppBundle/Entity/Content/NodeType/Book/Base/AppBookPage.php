<?php

namespace AppBundle\Entity\Content\NodeType\Book\Base;

use AppBundle\Entity\Content\NodeType\Article\ArticleNode;
use AppBundle\Entity\Content\NodeType\Blog\BlogNode;
use AppBundle\Entity\Content\NodeType\Book\BookNode;
use AppBundle\Entity\Content\NodeType\Book\BookPageSection;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppBookPage {
	
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
		$this->sections = new ArrayCollection();
	}
	
	/**
	 * @var BookNode
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeType\Book\BookNode",inversedBy="pages")
	 * @ORM\JoinColumn(name="id_book", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $book;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeType\Book\BookPageSection", mappedBy="page", cascade={"all"}, orphanRemoval=true)
	 */
	protected $sections;
	
	public function addSection(BookPageSection $item) {
		$this->sections->add($item);
		$item->setPage($this);
	}
	
	public function removeSection(BookPageSection $item) {
		$this->sections->removeElement($item);
		$item->setPage(null);
	}
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
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
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return BookNode
	 */
	public function getBook() {
		return $this->book;
	}
	
	/**
	 * @param BookNode $book
	 */
	public function setBook($book) {
		$this->book = $book;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getSections() {
		return $this->sections;
	}
	
	/**
	 * @param ArrayCollection $sections
	 */
	public function setSections($sections) {
		$this->sections = $sections;
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
	
	
	
}