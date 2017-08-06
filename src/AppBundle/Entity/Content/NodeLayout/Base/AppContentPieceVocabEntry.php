<?php

namespace AppBundle\Entity\Content\NodeLayout\Base;

use AppBundle\Entity\Content\NodeType\Article\ArticleNode;
use AppBundle\Entity\Content\NodeType\Blog\BlogNode;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Dictionary\Entry;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppContentPieceVocabEntry {
	
	/**
	 * ID_REF
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
	 * @var Entry
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dictionary\Entry",inversedBy="contentPieceEntries")
	 * @ORM\JoinColumn(name="id_entry", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $entry;
	
	/**
	 * @var ArticleNode
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\ContentPiece",inversedBy="vocabEntries")
	 * @ORM\JoinColumn(name="id_content_piece", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $contentPiece;
	
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
	 * @return Entry
	 */
	public function getEntry() {
		return $this->entry;
	}
	
	/**
	 * @param Entry $entry
	 */
	public function setEntry($entry) {
		$this->entry = $entry;
	}
	
	/**
	 * @return ArticleNode
	 */
	public function getContentPiece() {
		return $this->contentPiece;
	}
	
	/**
	 * @param ArticleNode $contentPiece
	 */
	public function setContentPiece($contentPiece) {
		$this->contentPiece = $contentPiece;
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
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
}