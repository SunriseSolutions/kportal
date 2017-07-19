<?php

namespace AppBundle\Entity\Location\Base;

use AppBundle\Entity\Location\Geolocation;

class AppOrganisationLocation {
	
	protected $stateChange;
	
	protected $id;
	
	/**
	 * Construct.
	 */
	public function __construct() {
		$this->position = 0;
		$this->enabled  = true;
	}
	
	public function __toString() {
		return $this->geolocation->getName();
	}
	
	protected $organisation;
	
	/**
	 * @var Geolocation
	 */
	protected $geolocation;
	protected $enabled;
	
	protected $listings;
	/**
	 * @var int
	 */
	protected $position;
	
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setPosition($position) {
		$this->position = $position;
	}
	
	public function getPosition() {
		return $this->position;
	}
	
	public function setGeolocation($geolocation) {
		if( ! $geolocation instanceof Geolocation) {
			$geolocationArray = $geolocation;
			$geolocation      = new Geolocation();
			$geolocation->setGeolocation($geolocationArray);
			$geolocation->setName($geolocationArray['address']);
//            $location->setGeolocation($geolocation);
		}
		$this->geolocation = $geolocation;
	}
	
	public function getGeolocation() {
		return $this->geolocation;
	}
	
	
	public function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}
	
	public function getOrganisation() {
		return $this->organisation;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setEnabled($enabled) {
		$this->enabled = $enabled;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function isEnabled() {
		return $this->enabled;
	}
	
	public function setListings($listings) {
		$this->listings = $listings;
	}
	
	public function getListings() {
		return $this->listings;
	}
	
	/**
	 * @return mixed
	 */
	public function getStateChange() {
		return $this->stateChange;
	}
	
	/**
	 * @param mixed $stateChange
	 */
	public function setStateChange($stateChange) {
		$this->stateChange = $stateChange;
	}
	
}