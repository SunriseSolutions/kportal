<?php
namespace Application\Sonata\MediaBundle\Entity\Base;

use Application\Sonata\UserBundle\Entity\User;
use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;


class Media extends BaseMedia
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var User
     */
    protected $avatarUser;

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}