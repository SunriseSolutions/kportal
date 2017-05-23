<?php

namespace AppBundle\Entity\Content\Base;

use AppBundle\Entity\Content\AppContentEntity;
use AppBundle\Entity\Content\PieceOfContent;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppPieceOfContent
{
    function __construct()
    {
        $this->locale = 'en';
    }

    /**
     * ID_REF
     * @ORM\Id
     * @ORM\Column(type="string", length=24)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
     */
    protected $id;

    /**
     * @var AppContentEntity
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\ContentEntity",inversedBy="contentPieces")
     * @ORM\JoinColumn(name="id_owner", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $owner;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default":false})
     */
    protected $container = false;

    /**
     * ID_REF
     * @var string
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    protected $topic;

    /**
     * ID_REF
     * @var string
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    protected $rootTopic;

    /**
     * @var string
     * @ORM\Column(type="string", length=5)
     */
    protected $locale;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $body;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getRootTopic()
    {
        return $this->rootTopic;
    }

    /**
     * @param string $rootTopic
     */
    public function setRootTopic($rootTopic)
    {
        $this->rootTopic = $rootTopic;
    }

    /**
     * @return bool
     */
    public function isContainer()
    {
        return $this->container;
    }

    /**
     * @param bool $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @return AppContentEntity
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param AppContentEntity $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }
}