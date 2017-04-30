<?php
namespace AppBundle\Entity\Content;
use Doctrine\ORM\Mapping as ORM;

class PieceOfContent
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=24)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
     */
    protected $id;

}