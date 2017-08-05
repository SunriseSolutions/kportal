<?php

namespace AppBundle\Entity\Content\NodeLayout\Base;

use AppBundle\Entity\Content\ContentEntity;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\ContentPiece;
use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppContentPieceH5P {
	
	function __construct() {
		$this->createdAt = new \DateTime();
	}
	
	/**
	 * @var ContentPiece
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\ContentPiece",inversedBy="h5pContentItems")
	 * @ORM\JoinColumn(name="id_content_piece", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $contentPiece;
	
	/**
	 * @var Content
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\H5P\Content",inversedBy="h5pContentItems")
	 * @ORM\JoinColumn(name="id_h5p_content", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $h5pContent;
	
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
	 * @return ContentPiece
	 */
	public function getContentPiece() {
		return $this->contentPiece;
	}
	
	/**
	 * @param ContentPiece $contentPiece
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
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return ContentNode
	 */
	public function getH5pContent() {
		return $this->h5pContent;
	}
	
	/**
	 * @param ContentNode $h5pContent
	 */
	public function setH5pContent($h5pContent) {
		$this->h5pContent = $h5pContent;
	}
	
	
}