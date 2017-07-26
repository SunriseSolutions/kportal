<?php

namespace AppBundle\Entity\H5P\ContentType\MultiChoice\Base;

use AppBundle\Entity\Content\ContentNodeH5P;
use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass
 */
abstract class AppMultiChoiceMedia {
	
	/**
	 * @var array
	 */
	protected $imageLib;
	
	/**
	 * @var array
	 */
	protected $flowplayerLib;
	
	/**
	 * @var array
	 */
	protected $vidLib;
	
	function __construct() {
//		parent::__construct();
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
	 * @var ContentMultiChoice
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice", inversedBy="multichoiceMedia")
	 * @ORM\JoinColumn(name="id_h5p_multichoice", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $question;
	
	/**
	 * @var Media
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media\Media",inversedBy="mediaH5PMultiChoices")
	 * @ORM\JoinColumn(name="id_media", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 */
	protected $media;
	
	/**
	 * @return ContentMultiChoice
	 */
	public function getQuestion() {
		return $this->question;
	}
	
	/**
	 * @param ContentMultiChoice $question
	 */
	public function setQuestion($question) {
		$this->question = $question;
	}
	
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