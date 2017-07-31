<?php

namespace AppBundle\Entity\Dictionary\Base;

use AppBundle\Entity\Content\NodeType\Article\ArticleVocabEntry;
use AppBundle\Entity\Dictionary\Entry;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\NLP\Sense;
use Bean\Component\Dictionary\Model\EntryExample as Model;
use AppBundle\Entity\Dictionary\Entry as Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppEntryExample extends Model {
	
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
	 * @var Entry
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dictionary\Entry",inversedBy="exampleEntries")
	 * @ORM\JoinColumn(name="id_example", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $example;
	
	/**
	 * @var Entry
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dictionary\Entry",inversedBy="examples")
	 * @ORM\JoinColumn(name="id_example_entry", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $entry;
}