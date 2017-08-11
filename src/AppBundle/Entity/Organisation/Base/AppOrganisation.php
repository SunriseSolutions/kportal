<?php

namespace AppBundle\Entity\Organisation\Base;

use AppBundle\Entity\Location\OrganisationLocation;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\Organisation\Employment;
use AppBundle\Entity\User\User;
use Bean\Component\Organisation\Model\Organisation as OrganisationModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/** @ORM\MappedSuperclass */
class AppOrganisation extends OrganisationModel {
	function __construct() {
		$this->locations   = new ArrayCollection();
		$this->employments = new ArrayCollection();
		$this->createdAt   = new \DateTime();
		$this->enabled     = true;
	}
	
	
	public function getAdminPosition() {
		if(empty($this->adminEmail)) {
			return null;
		}
		/** @var Employment $pos */
		foreach($this->employments as $pos) {
			if($pos->getEmail() === $this->adminEmail) {
				return $pos;
			}
		}
		
		return null;
	}
	
	/**
	 * @param Employment $position
	 *
	 * @return bool
	 */
	public function isEmploymentExistent(Employment $position) {
		$isExistent = false;
		/** @var Employment $pos */
		foreach($this->positions as $pos) {
			if( ! (empty($position->getEmployee()) || empty($pos->getEmployee()))) {
				if($position->getEmployee()->getEmail() === $pos->getEmployee()->getEmail()) {
					$isExistent = true;
				}
			}
		}
		
		return $isExistent;
	}
	
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 */
	protected
		$id;
	
	/**
	 * @var ArrayCollection
	 * ORM\OneToMany(targetEntity="AppBundle\Entity\Location\OrganisationLocation", mappedBy="organisation",cascade={"all"}, orphanRemoval=true)
	 * ORM\OrderBy({"position" = "ASC"})
	 * Serializer\Exclude()
	 */
	protected
		$locations;
	
	/**
	 * @param OrganisationLocation $location
	 *
	 * @return OrganisationLocation
	 */
	public
	function removeLocation(
		OrganisationLocation $location
	) {
		$this->locations->removeElement($location);
		$location->setOrganisation(null);
		
		return $this;
	}
	
	/**
	 * @param OrganisationLocation $location
	 *
	 * @return OrganisationLocation
	 */
	public
	function addLocation(
		OrganisationLocation $location
	) {
		$this->locations->add($location);
		$location->setOrganisation($this);
		
		return $this;
	}
	
	/**
	 * @var ArrayCollection
	 * ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Employment", mappedBy="employer", cascade={"all"}, orphanRemoval=true)
	 * @Serializer\Exclude()
	 */
	protected
		$employments;
	
	/**
	 * @var OrganisationSetting
	 * ORM\OneToOne(targetEntity="Application\Bean\OrganisationBundle\Entity\OrganisationSetting", mappedBy="organisation", cascade={"all"}, orphanRemoval=true)
	 */
	protected $setting;
	
	/**
	 * @var Media $logo
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Media\Media", inversedBy="logoOrganisation", cascade={"all"}, orphanRemoval=true)
	 * @ORM\JoinColumn(name="id_logo", referencedColumnName="id")
	 */
	protected
		$logo;
	
	
	/**
	 * @var \DateTime $createdAt
	 * @ORM\Column(type="datetime", name="created_at")
	 */
	protected
		$createdAt;
	
	/**
	 * @var bool
	 * @ORM\Column(type="boolean", name="enabled", options={"default":false})
	 */
	protected
		$enabled;
	
	/**
	 * @var string
	 * @ORM\Column(length=150, nullable=true)
	 */
	protected
		$hotline;
	
	/**
	 * @var string
	 * @ORM\Column(length=150, nullable=true)
	 */
	protected
		$regNo;
	
	/**
	 * @var string
	 * @ORM\Column(length=150)
	 */
	protected
		$slug;
	
	/**
	 * @var string
	 * @ORM\Column(length=150)
	 */
	protected
		$name;
	
	/**
	 * @var string
	 * @ORM\Column(length=150, nullable=true)
	 */
	protected
		$code;

//////////////////////////////    //////////////////////////////
//////////////////////////////    //////////////////////////////
//////////////////////////////    //////////////////////////////
	
	/**
	 * @return int
	 */
	public
	function getId() {
		return $this->id;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getLocations() {
		return $this->locations;
	}
	
	/**
	 * @param ArrayCollection $locations
	 */
	public function setLocations($locations) {
		$this->locations = $locations;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getPositions() {
		return $this->positions;
	}
	
	/**
	 * @param ArrayCollection $positions
	 */
	public function setPositions($positions) {
		$this->positions = $positions;
	}
	
	/**
	 * @return Media
	 */
	public function getLogo() {
		return $this->logo;
	}
	
	/**
	 * @param Media $logo
	 */
	public function setLogo($logo) {
		$this->logo = $logo;
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
	 * @return bool
	 */
	public function isEnabled() {
		return $this->enabled;
	}
	
	/**
	 * @param bool $enabled
	 */
	public function setEnabled($enabled) {
		$this->enabled = $enabled;
	}
	
	/**
	 * @return string
	 */
	public function getHotline() {
		return $this->hotline;
	}
	
	/**
	 * @param string $hotline
	 */
	public function setHotline($hotline) {
		$this->hotline = $hotline;
	}
	
	/**
	 * @return string
	 */
	public function getRegNo() {
		return $this->regNo;
	}
	
	/**
	 * @param string $regNo
	 */
	public function setRegNo($regNo) {
		$this->regNo = $regNo;
	}
	
	/**
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}
	
	/**
	 * @param string $slug
	 */
	public function setSlug($slug) {
		$this->slug = $slug;
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}
	
	/**
	 * @param string $code
	 */
	public function setCode($code) {
		$this->code = $code;
	}
}