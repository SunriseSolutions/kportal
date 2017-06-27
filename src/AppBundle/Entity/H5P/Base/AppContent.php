<?php

namespace AppBundle\Entity\H5P\Base;

use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass
 * @ORM\Entity
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
		$this->createdAt = new \DateTime();
	}
	
	
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
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $enabled = true;
	
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
	 * @ORM\Column(type="text")
	 */
	protected $keywords;
	
	/**
	 * @var string
	 * @ORM\Column(type="text")
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
	protected $embedType;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=127)
	 */
	protected $contentType;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=127)
	 */
	protected $author;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=7)
	 */
	protected $license;
	
}