<?php

namespace AppBundle\Entity\H5P\Base;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\Dependency;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppContentMedia {
	
	function __construct() {
	}
	
	/**
	 * @var array
	 */
	protected $imageLib = [
		'machineName'  => 'H5P.Image',
		'majorVersion' => 1,
		'minorVersion' => 0,
		'patchVersion' => 28
	];
	
	/**
	 * @var array
	 */
	protected $flowplayerLib = [
		'machineName'  => 'flowplayer',
		'majorVersion' => 1,
		'minorVersion' => 0,
		'patchVersion' => 5
	];
	
	/**
	 * @var array
	 */
	protected $vidLib = [
		'machineName'  => 'H5P.Video',
		'majorVersion' => 1,
		'minorVersion' => 3,
		'patchVersion' => 4
	];
	
	/**
	 * @var int $id
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	/**
	 * @var Media
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media\Media",inversedBy="mediaH5PContent")
	 * @ORM\JoinColumn(name="id_media", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 */
	protected $media;
	
	/**
	 * @return Media
	 */
	public function getMedia() {
		return $this->media;
	}
	
	/**
	 * @param Media $media
	 */
	public function setMedia($media) {
		$this->media = $media;
	}
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return array
	 */
	public function getImageLib() {
		return $this->imageLib;
	}
	
	/**
	 * @param array $imageLib
	 */
	public function setImageLib($imageLib) {
		$this->imageLib = $imageLib;
	}
	
	/**
	 * @return array
	 */
	public function getFlowplayerLib() {
		return $this->flowplayerLib;
	}
	
	/**
	 * @param array $flowplayerLib
	 */
	public function setFlowplayerLib($flowplayerLib) {
		$this->flowplayerLib = $flowplayerLib;
	}
	
	/**
	 * @return array
	 */
	public function getVidLib() {
		return $this->vidLib;
	}
	
	/**
	 * @param array $vidLib
	 */
	public function setVidLib($vidLib) {
		$this->vidLib = $vidLib;
	}
}