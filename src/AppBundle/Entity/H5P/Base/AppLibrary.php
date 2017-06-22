<?php

namespace AppBundle\Entity\H5P\Base;

use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppLibrary extends BaseGallery {
	/**
	 * @var int $id
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	//TODO Implement
	
	protected $createdAt;
	protected $updatedAt;
	protected $machineName;
	protected $title;
	protected $majorVersion;
	protected $minorVersion;
	protected $patchVersion;
	protected $runnable;
	protected $restricted;
	protected $fullscreen;
	protected $embedTypes;
	protected $preloadedJs;
	protected $preloadedCss;
	protected $dropLibraryCss;
	protected $semantics;
	protected $tutorialUrl;
	protected $iconIncluded;
	
	
}