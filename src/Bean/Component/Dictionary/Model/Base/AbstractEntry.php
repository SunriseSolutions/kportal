<?php

namespace Bean\Component\Dictionary\Model\Base;

use Bean\Component\NLP\Model\Sense;
use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractEntry implements EntryInterface {
	const TYPE_NOUN = 'NOUN';
	const TYPE_VERB = 'VERB';
	const TYPE_PHRASAL_VERB = 'PHRASAL_VERB';
	const TYPE_SENTENCE = 'SENTENCE';
	const TYPE_PREPOSITION = 'PREPOSITION';
	
	/**
	 * Primary identifier, details depend on storage layer.
	 */
	protected $id;
	
	/** en_gb, en_us, fr, vi
	 * @var string
	 */
	protected $locale;
	
	/**
	 * Could be a word like "hello/bonjour/こんにちは" or a phrase like "go doing sth" or "I love my dog"
	 * @var string
	 */
	protected $phrase;
	
	protected $phoneticSymbols;
	
	/**
	 * @var string
	 */
	protected $briefComment;
	
	/**
	 * @var string
	 */
	protected $definition;
	
	/**
	 * Noun, Verb, Phrasal Verb, Sentence
	 * @var string
	 */
	protected $type;
	
	/**
	 * @var Sense
	 */
	protected $sense;
	
	/**
	 * A list of (EntryInterface)
	 * @var ArrayCollection
	 */
	protected $usages;
	
	public function addUsage(EntryInterface $entry) {
		$this->usages->add($entry);
		$entry->setUserEntry($this);
	}
	
	public function removeUsage(EntryInterface $entry) {
		$this->usages->remove($entry);
		$entry->setUserEntry(null);
	}
	
	/**
	 * A list of sample phrases/statements (EntryInterface)
	 * @var ArrayCollection
	 */
	protected $samples;
	
	public function addSample(EntryInterface $entry) {
		$this->samples->add($entry);
		$entry->setSampleUserEntry($this);
	}
	
	public function removeSample(EntryInterface $entry) {
		$this->samples->remove($entry);
		$entry->setSampleUserEntry(null);
	}
	
	/**
	 * @var EntryInterface
	 */
	protected $userEntry;
	
	/**
	 * @var EntryInterface
	 */
	protected $sampleUserEntry;
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @return mixed
	 */
	public function getLocale() {
		return $this->locale;
	}
	
	/**
	 * @param mixed $locale
	 */
	public function setLocale($locale) {
		$this->locale = $locale;
	}
	
	/**
	 * @return mixed
	 */
	public function getPhrase() {
		return $this->phrase;
	}
	
	/**
	 * @param mixed $phrase
	 */
	public function setPhrase($phrase) {
		$this->phrase = $phrase;
	}
	
	/**
	 * @return mixed
	 */
	public function getPhoneticSymbols() {
		return $this->phoneticSymbols;
	}
	
	/**
	 * @param mixed $phoneticSymbols
	 */
	public function setPhoneticSymbols($phoneticSymbols) {
		$this->phoneticSymbols = $phoneticSymbols;
	}
	
	/**
	 * @return mixed
	 */
	public function getDefinition() {
		return $this->definition;
	}
	
	/**
	 * @param mixed $definition
	 */
	public function setDefinition($definition) {
		$this->definition = $definition;
	}
	
	/**
	 * @return mixed
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @param mixed $type
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
	/**
	 * @return mixed
	 */
	public function getSense() {
		return $this->sense;
	}
	
	/**
	 * @param mixed $sense
	 */
	public function setSense($sense) {
		$this->sense = $sense;
	}
	
	/**
	 * @return mixed
	 */
	public function getSamples() {
		return $this->samples;
	}
	
	/**
	 * @param mixed $samples
	 */
	public function setSamples($samples) {
		$this->samples = $samples;
	}
	
	/**
	 * @return string
	 */
	public function getBriefComment() {
		return $this->briefComment;
	}
	
	/**
	 * @param string $briefComment
	 */
	public function setBriefComment($briefComment) {
		$this->briefComment = $briefComment;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getUsages() {
		return $this->usages;
	}
	
	/**
	 * @param ArrayCollection $usages
	 */
	public function setUsages($usages) {
		$this->usages = $usages;
	}
	
	/**
	 * @return EntryInterface
	 */
	public function getUserEntry() {
		return $this->userEntry;
	}
	
	/**
	 * @param EntryInterface $userEntry
	 */
	public function setUserEntry($userEntry) {
		$this->userEntry = $userEntry;
	}
	
	/**
	 * @return EntryInterface
	 */
	public function getSampleUserEntry() {
		return $this->sampleUserEntry;
	}
	
	/**
	 * @param EntryInterface $sampleUserEntry
	 */
	public function setSampleUserEntry($sampleUserEntry) {
		$this->sampleUserEntry = $sampleUserEntry;
	}
}