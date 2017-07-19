<?php

namespace AppBundle\Entity\Organisation\Base;

use AppBundle\Entity\Media\Media;
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
	
	
	/**
	 * @param OrganisationSetting $setting
	 */
	public function setSetting($setting) {
		$this->setting = $setting;
		$setting->setOrganisation($this);
	}
	
	/**
	 * @return bool
	 */
	public
	function isTypeChannelPartner() {
		return $this->typeConsumerChannelPartner || $this->typeBusinessChannelPartner;
	}
	
	/**
	 * @return ConsumerChannelPartner
	 */
	public function getConsumerChannelPartner() {
		if(empty($this->channelPartner)) {
			return null;
		}
		
		return $this->channelPartner->getConsumerChannelPartner();
	}
	
	/**
	 * @return BusinessChannelPartner
	 */
	public function getBusinessChannelPartner() {
		if(empty($this->channelPartner)) {
			return null;
		}
		
		return $this->channelPartner->getBusinessChannelPartner();
	}
	
	public function purgeOldAdminPositions() {
		$removedPositions = new ArrayCollection();
		/** @var Position $position */
		foreach($this->positions as $position) {
			if($position->hasRole(Position::ROLE_ADMIN)) {
				if(empty($this->typeEmployer)) {
					if($position->getEmail() !== $this->adminEmail) {
						$this->removePosition($position);
						$removedPositions->add($position);
					}
				}
			}
		}
		
		return $removedPositions;
	}
	
	public function getAdminPosition() {
		if(empty($this->adminEmail)) {
			return null;
		}
		/** @var Position $pos */
		foreach($this->positions as $pos) {
			if($pos->getEmail() === $this->adminEmail) {
				return $pos;
			}
		}
		$pos = new Position();
		$pos->setEnabled(true);
		$pos->addRole(Position::ROLE_ADMIN);
		$this->addPosition($pos);
		$adminUser = new User();
		$adminUser->setEnabled(true);
		$adminUser->addRole('ROLE_HEALTH_ADMIN');
		$adminUser->setPlainPassword('123456');
		$adminUser->setEmail($this->adminEmail);
		$adminUser->setUsername($this->adminEmail);
		$pos->setEmployee($adminUser);
		
		return $pos;
	}
	
	public function getTypes() {
		$types = array();
		if($this->isTypeConsumerSalesPartner()) {
			$types[] = self::TYPE_CONSUMER_SALES_PARTNER;
		}
		if($this->isTypeBusinessSalesPartner()) {
			$types[] = self::TYPE_BUSINESS_SALES_PARTNER;
		}
		if($this->isTypeConsumerChannelPartner()) {
			$types[] = self::TYPE_CONSUMER_CHANNEL_PARTNER;
		}
		if($this->isTypeBusinessChannelPartner()) {
			$types[] = self::TYPE_BUSINESS_CHANNEL_PARTNER;
		}
		if($this->isTypePrincipal()) {
			$types[] = self::TYPE_PRINCIPAL;
		}
		if($this->isTypeClinic()) {
			$types[] = self::TYPE_CLINIC;
		}
		if($this->isTypeEmployer()) {
			$types[] = self::TYPE_EMPLOYER;
		}
		
		return $types;
	}
	
	/**
	 * @param Position $position
	 *
	 * @return bool
	 */
	public function isPositionExistent(Position $position) {
		$isExistent = false;
		/** @var Position $pos */
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
	 * @param bool $typeClinic
	 */
	public function setTypeClinic($typeClinic) {
		$this->typeClinic = $typeClinic;
		if($typeClinic) {
			if(empty($this->clinic)) {
				$this->clinic = new Clinic();
				$this->clinic->setOrganisation($this);
			}
		}
	}
	
	/**
	 * @param bool $typeSalesPartner
	 */
	public function setTypeConsumerSalesPartner($typeSalesPartner) {
		$this->typeConsumerSalesPartner = $typeSalesPartner;
		if($typeSalesPartner) {
			$this->setTypeSalesPartner(true);
		} elseif(empty($this->typeBusinessChannelPartner)) {
			$this->setTypeSalesPartner(false);
		}
	}
	
	/**
	 * @param bool $typeSalesPartner
	 */
	public function setTypeBusinessSalesPartner($typeSalesPartner) {
		$this->typeBusinessSalesPartner = $typeSalesPartner;
		if($typeSalesPartner) {
			$this->setTypeSalesPartner(true);
		} elseif(empty($this->typeConsumerChannelPartner)) {
			$this->setTypeSalesPartner(false);
		}
	}
	
	public
	function setTypeSalesPartner(
		$typeSalesPartner
	) {
		if($typeSalesPartner) {
			$this->typeSalesPartner = true;
			if(empty($this->salesPartner)) {
				$this->salesPartner = new SalesPartner();
				$this->salesPartner->setOrganisation($this);
			}
		} else {
			$this->typeSalesPartner = false;
		}
	}
	
	/**
	 * @return bool
	 */
	public
	function isTypeSalesPartner() {
		if($this->isTypeBusinessSalesPartner() || $this->isTypeConsumerSalesPartner()) {
			return $this->typeSalesPartner = true;
		}
		
		return $this->typeSalesPartner = false;
	}
	
	/**
	 * @param bool $typeConsumerChannelPartner
	 */
	public
	function setTypeConsumerChannelPartner(
		$typeChannelPartner
	) {
		$this->typeConsumerChannelPartner = $typeChannelPartner;
		if($typeChannelPartner) {
			if(empty($this->channelPartner)) {
				$this->channelPartner = new ChannelPartner();
				$this->channelPartner->setOrganisation($this);
			}
			$consumerCP = $this->channelPartner->getConsumerChannelPartner();
			if(empty($consumerCP)) {
				$consumerCP = new ConsumerChannelPartner();
				$this->channelPartner->setConsumerChannelPartner($consumerCP);
				$consumerCP->setChannelPartner($this->channelPartner);
			}
		}
	}
	
	/**
	 * @param bool $typeBusinessChannelPartner
	 */
	public
	function setTypeBusinessChannelPartner(
		$typeChannelPartner
	) {
		$this->typeBusinessChannelPartner = $typeChannelPartner;
		if($typeChannelPartner) {
			if(empty($this->channelPartner)) {
				$this->channelPartner = new ChannelPartner();
				$this->channelPartner->setOrganisation($this);
			}
			$bizCP = $this->channelPartner->getBusinessChannelPartner();
			if(empty($bizCP)) {
				$bizCP = new BusinessChannelPartner();
				$this->channelPartner->setBusinessChannelPartner($bizCP);
				$bizCP->setChannelPartner($this->channelPartner);
			}
		}
	}
	
	/**
	 * @param bool $typeEmployer
	 */
	public
	function setTypeEmployer(
		$typeEmployer
	) {
		$this->typeEmployer = $typeEmployer;
		if($typeEmployer) {
			if(empty($this->employer)) {
				$this->employer = new BusinessEmployer();
				$this->employer->setOrganisation($this);
			}
		}
	}
	
	/**
	 * @param bool $typePrincipal
	 */
	public
	function setTypePrincipal(
		$typePrincipal
	) {
		$this->typePrincipal = $typePrincipal;
		if($typePrincipal) {
			if(empty($this->principal)) {
				$this->principal = new Principal();
				$this->principal->setOrganisation($this);
			}
		}
	}
	
	
	/**
	 * @param string $adminFirstname
	 */
	public
	function setAdminFirstname(
		$adminFirstname
	) {
		$this->adminFirstname = $adminFirstname;
		$this->adminName      = $this->adminFirstname . ' ' . $this->adminMiddlename . ' ' . $this->adminLastname;
	}
	
	/**
	 * @param string $adminLastname
	 */
	public
	function setAdminLastname(
		$adminLastname
	) {
		$this->adminLastname = $adminLastname;
		$this->adminName     = $this->adminFirstname . ' ' . $this->adminMiddlename . ' ' . $this->adminLastname;
	}
	
	/**
	 * @param string $adminMiddlename
	 */
	public
	function setAdminMiddlename(
		$adminMiddlename
	) {
		$this->adminMiddlename = $adminMiddlename;
		$this->adminName       = $this->adminFirstname . ' ' . $this->adminMiddlename . ' ' . $this->adminLastname;
	}
	
	public
	function getAdminName() {
		if(empty($this->adminName)) {
			$this->adminName = $this->adminFirstname . ' ' . $this->adminMiddlename . ' ' . $this->adminLastname;
		}
		
		return $this->adminName;
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