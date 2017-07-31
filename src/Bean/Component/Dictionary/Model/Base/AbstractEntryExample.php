<?php

namespace Bean\Component\Dictionary\Model\Base;

use Bean\Component\NLP\Model\Sense;
use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractEntryExample {
	
	/**
	 * Primary identifier, details depend on storage layer.
	 */
	protected $id;
	
	/**
	 * A list of sample phrases/statements
	 * @var EntryInterface
	 */
	protected $example;
	
	/**
	 * @var EntryInterface
	 */
	protected $entry;
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return EntryInterface
	 */
	public function getExample() {
		return $this->example;
	}
	
	/**
	 * @param EntryInterface $example
	 */
	public function setExample($example) {
		$this->example = $example;
	}
	
	/**
	 * @return EntryInterface
	 */
	public function getEntry() {
		return $this->entry;
	}
	
	/**
	 * @param EntryInterface $entry
	 */
	public function setEntry($entry) {
		$this->entry = $entry;
	}
}