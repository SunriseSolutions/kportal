<?php

namespace AppBundle\Entity\User\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Media\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppUser extends BaseUser {
	
	const ROLE_ADMIN = 'ROLE_ADMIN';
	
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * One Customer has One Cart.
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Content\ContentEntity\IndividualEntity", mappedBy="owner")
	 */
	private $individualEntity;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $christianName;
	
	/**
	 * @var  ArrayCollection $addresses
	 */
	protected $addresses;
	
	/**
	 * @var Media
	 */
	protected $avatar;
	
	/**
	 * @var string
	 */
	protected $maritalStatus;
	
	/**
	 * @var string
	 */
	protected $nationality;
	
	/**
	 * @return mixed
	 */
	public function getIndividualEntity() {
		return $this->individualEntity;
	}
	
	/**
	 * @param mixed $individualEntity
	 */
	public function setIndividualEntity($individualEntity) {
		$this->individualEntity = $individualEntity;
	}
}