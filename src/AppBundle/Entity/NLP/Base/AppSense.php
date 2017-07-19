<?php

namespace AppBundle\Entity\Dictionary\Base;

use Bean\Component\Dictionary\Model\Entry;
use Bean\Component\NLP\Model\Sense;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppSense extends Sense {
	
	function __construct() {
	
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
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $data;
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
}