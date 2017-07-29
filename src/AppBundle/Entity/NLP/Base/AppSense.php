<?php

namespace AppBundle\Entity\NLP\Base;

use AppBundle\Entity\Dictionary\Entry;
use Bean\Component\NLP\Model\Sense;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppSense extends Sense {
	
	function __construct() {
		$this->entries = new ArrayCollection();
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
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dictionary\Entry", mappedBy="sense", cascade={"all"}, orphanRemoval=true)
	 */
	protected $entries;
	
	public function addEntry(Entry $entry) {
		$this->entries->add($entry);
		$entry->setSense($this);
	}
	
	public function removeEntry(Entry $entry) {
		$this->entries->remove($entry);
		$entry->setSense(null);
	}
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=500, nullable=true)
	 */
	protected $abstract;
	
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