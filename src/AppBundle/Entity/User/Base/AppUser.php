<?php

namespace AppBundle\Entity\User\Base;

use AppBundle\Entity\Content\PieceOfContent;
use AppBundle\Entity\Media\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppUser extends BaseUser
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    function __construct()
    {
        parent::__construct();
    }

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


}