<?php

namespace AppBundle\Entity\Dictionary\Base;

use AppBundle\Entity\Content\ContentPiece\ContentPieceVocabEntry;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\NLP\Sense;
use Bean\Component\Dictionary\Model\Entry as Model;
use AppBundle\Entity\Dictionary\Entry as Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppEntry extends Model {
	
	function __construct() {
		$this->examples = new ArrayCollection();
		$this->usages   = new ArrayCollection();
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
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dictionary\EntryUsage", mappedBy="entry", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $usages;
	
	/**
	 * @var Entity
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dictionary\EntryUsage", mappedBy="usage", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $usageEntries;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dictionary\EntryExample", mappedBy="entry", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $examples;
	
	/**
	 * @var Entity
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dictionary\EntryExample", mappedBy="example", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $exampleEntries;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\ContentPiece\ContentPieceVocabEntry", mappedBy="entry", cascade={"all"}, orphanRemoval=true)
	 */
	protected $contentPieceEntries;
	
	public function addContentPieceEntry(ContentPieceVocabEntry $item) {
		$this->contentPieceEntries->add($item);
		$item->setEntry($this);
	}
	
	public function removeContentPieceEntry(ContentPieceVocabEntry $item) {
		$this->contentPieceEntries->removeElement($item);
		$item->setEntry(null);
	}
	
	/**
	 * @var Media
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media\Media", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_audio", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $audio;
	
	/**
	 * @var Sense
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\NLP\Sense",inversedBy="entries")
	 * @ORM\JoinColumn(name="id_sense", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $sense;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=5)
	 */
	protected $locale;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $phrase;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $phoneticSymbols;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $briefComment;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=500, nullable=true)
	 */
	protected $definition;
	
	/**
	 * Noun, Verb, Phrasal Verb, Sentence
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $type;
	
	/**
	 * @return Media
	 */
	public function getAudio() {
		return $this->audio;
	}
	
	/**
	 * @param Media $audio
	 */
	public function setAudio($audio) {
		$this->audio = $audio;
	}
	
}