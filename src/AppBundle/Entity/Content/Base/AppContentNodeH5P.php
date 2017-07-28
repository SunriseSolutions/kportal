<?php

namespace AppBundle\Entity\Content\Base;

use AppBundle\Entity\Content\ContentEntity;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppContentNodeH5P {
	
	function __construct() {
		$this->createdAt = new \DateTime();
	}
	
	/**
	 * @var ContentNode
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\ContentNode",inversedBy="h5pContentItems")
	 * @ORM\JoinColumn(name="id_content_node", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $contentNode;
	
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
	 * @return ContentNode
	 */
	public function getContentNode() {
		return $this->contentNode;
	}
	
	/**
	 * @param ContentNode $contentNode
	 */
	public function setContentNode($contentNode) {
		$this->contentNode = $contentNode;
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