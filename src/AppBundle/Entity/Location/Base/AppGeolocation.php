<?php
namespace AppBundle\Entity\Location\Base;

use Bean\Bundle\LocationBundle\Model\Geolocation as GeolocationModel;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppGeolocation extends GeolocationModel {
	public function setAddress($address) {
		parent::setAddress($address);
		if(empty($this->name)) {
			$this->name = $address;
		}
	}
	
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var ArrayCollection
	 */
	protected $organisationLocations;
	
	/**
	 * @param OrganisationLocation $orgLoc
	 */
	public function addOrganisationLocation($orgLoc) {
		$this->organisationLocations->add($orgLoc);
		$orgLoc->setGeolocation($this);
		
		return $this;
	}
	
	/**
	 * @param OrganisationLocation $orgLoc
	 */
	public function removeOrganisationLocation($orgLoc) {
		$this->organisationLocations->removeElement($orgLoc);
		$orgLoc->setGeolocation(null);
		
		return $this;
	}
	
	public function getOrganisationLocations() {
		return $this->organisationLocations;
	}
	
	public function setOrganisationLocations($organisationLocations) {
		$this->organisationLocations = $organisationLocations;
		
		return $this;
	}
	
	/**
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	
}