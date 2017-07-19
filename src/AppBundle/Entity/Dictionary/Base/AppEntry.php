<?php

namespace AppBundle\Entity\Dictionary\Base;

use AppBundle\Entity\Content\ArticleVocabEntry;
use Bean\Component\Dictionary\Model\Entry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppEntry extends Entry {
	
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
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\ArticleVocabEntry", mappedBy="entry", cascade={"all"}, orphanRemoval=true)
	 */
	protected $articleEntries;
	
	public function addArticleEntry(ArticleVocabEntry $item) {
		$this->articleEntries->add($item);
		$item->setEntry($this);
	}
	
	public function removeArticleEntry(ArticleVocabEntry $item) {
		$this->articleEntries->removeElement($item);
		$item->setEntry(null);
	}
	
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
	
}