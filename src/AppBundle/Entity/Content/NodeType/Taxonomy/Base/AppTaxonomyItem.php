<?php

namespace AppBundle\Entity\Content\NodeType\Taxonomy\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyNode;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppTaxonomyItem {
	
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
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @var TaxonomyNode
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyNode",inversedBy="items")
	 * @ORM\JoinColumn(name="id_blog", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $taxonomy;
	
	/**
	 * @var ContentNode
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\ContentNode" )
	 * @ORM\JoinColumn(name="id_content_node", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $content;
	
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
	 * @var string
	 * @ORM\Column(type="string", length=256, nullable=true)
	 */
	protected
		$title;
	
	/**
	 * @return TaxonomyNode
	 */
	public function getTaxonomy() {
		return $this->taxonomy;
	}
	
	/**
	 * @param TaxonomyNode $taxonomy
	 */
	public function setTaxonomy($taxonomy) {
		$this->taxonomy = $taxonomy;
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
	 * @return ContentNode
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 * @param ContentNode $content
	 */
	public function setContent($content) {
		$this->content = $content;
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
}