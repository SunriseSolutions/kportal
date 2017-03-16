<?php
namespace AppBundle\Entity\User;

use Application\Bean\LocationBundle\Entity\Geolocation;

class Address
{
    public function getAddress()
    {
        return empty($this->geolocation) ? null : $this->geolocation->getAddress();
    }

    /**
     * @var int $id
     */
    private $id;

    /**
     * @var Geolocation
     */
    private $geolocation;

    /**
     * @var User
     */
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Geolocation
     */
    public function getGeolocation()
    {
        return $this->geolocation;
    }

    /**
     * @param Geolocation $geolocation
     */
    public function setGeolocation($geolocation)
    {
        $this->geolocation = $geolocation;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}