<?php

namespace Bean\Component\Dictionary\Model\Base;

use Bean\Component\NLP\Model\Sense;
use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractEntryUsage {
	
	/**
	 * Primary identifier, details depend on storage layer.
	 */
	protected $id;
	
	/**
	 * A list of sample phrases/statements
	 * @var EntryInterface
	 */
	protected $usage;
	
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
	public function getUsage() {
		return $this->usage;
	}
	
	/**
	 * @param EntryInterface $usage
	 */
	public function setUsage($usage) {
		$this->usage = $usage;
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