<?php

namespace AppBundle\Entity\H5P\ContentType\QuestionSet\Base;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppSetQuestion {
	
	function __construct() {
		// initiate default versioning
	}
	
	/**
	 * @var int $id
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	/**
	 * @var Content
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\H5P\Content", cascade={"merge","persist"})
	 * @ORM\JoinColumn(name="id_h5p_content", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 */
	protected $h5pContent;
	
	/**
	 * @return Content
	 */
	public function getH5pContent() {
		return $this->h5pContent;
	}
	
	/**
	 * @param Content $h5pContent
	 */
	public function setH5pContent($h5pContent) {
		$this->h5pContent = $h5pContent;
	}
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
}