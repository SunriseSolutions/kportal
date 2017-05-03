<?php

namespace AppBundle\Entity\Content;

use AppBundle\Entity\NLP\Sense;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__piece")
 */
class PieceOfContent
{
    function __construct()
    {
        $this->locale = 'en';

    }

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=24)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     */
    protected $topic;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     */
    protected $rootTopic;

    /**
     * @var string
     * @ORM\Column(type="string")
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
}