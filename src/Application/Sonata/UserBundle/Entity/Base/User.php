<?php
namespace Application\Sonata\UserBundle\Entity\Base;


use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

class User extends BaseUser
{
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