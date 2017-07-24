<?php

namespace AppBundle\Entity\Media\Base;

use AppBundle\Entity\Media\Media;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Entity\User\User;
use Sonata\MediaBundle\Entity\BaseMedia;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppMedia extends BaseMedia {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	/**
	 * @var Media
	 */
	protected $thumbnail;
	
	/**
	 * @var User
	 */
	protected $avatarUser;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceMedia", mappedBy="media", orphanRemoval=true)
	 */
	protected $mediaH5PMultiChoices;
	
	
	/**
	 * @var Organisation
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Organisation\Organisation", mappedBy="logo")
	 */
	protected $logoOrganisation;
	
	/**
	 * Get id
	 *
	 * @return int $id
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return Organisation
	 */
	public function getLogoOrganisation() {
		return $this->logoOrganisation;
	}
	
	/**
	 * @param Organisation $logoOrganisation
	 */
	public function setLogoOrganisation($logoOrganisation) {
		$this->logoOrganisation = $logoOrganisation;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getBannerOrganisations() {
		return $this->bannerOrganisations;
	}
	
	/**
	 * @param ArrayCollection $bannerOrganisations
	 */
	public function setBannerOrganisations($bannerOrganisations) {
		$this->bannerOrganisations = $bannerOrganisations;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getIntroVideos() {
		return $this->introVideos;
	}
	
	/**
	 * @param ArrayCollection $introVideos
	 */
	public function setIntroVideos($introVideos) {
		$this->introVideos = $introVideos;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getResumeCandidates() {
		return $this->resumeCandidates;
	}
	
	/**
	 * @param ArrayCollection $resumeCandidates
	 */
	public function setResumeCandidates($resumeCandidates) {
		$this->resumeCandidates = $resumeCandidates;
	}
	
	/**
	 * @return Media
	 */
	public function getThumbnail() {
		return $this->thumbnail;
	}
	
	/**
	 * @param Media $thumbnail
	 */
	public function setThumbnail($thumbnail) {
		$this->thumbnail = $thumbnail;
	}
	
	/**
	 * @return User
	 */
	public function getAvatarUser() {
		return $this->avatarUser;
	}
	
	/**
	 * @param User $avatarUser
	 */
	public function setAvatarUser($avatarUser) {
		$this->avatarUser = $avatarUser;
	}
	
	/**
	 * @return CandidateAnswer
	 */
	public function getVideoAnswer() {
		return $this->videoAnswer;
	}
	
	/**
	 * @param CandidateAnswer $videoAnswer
	 */
	public function setVideoAnswer($videoAnswer) {
		$this->videoAnswer = $videoAnswer;
	}
	
	
}