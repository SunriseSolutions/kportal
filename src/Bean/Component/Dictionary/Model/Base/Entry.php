<?php
namespace Bean\Component\Dictionary\Model\Base;

use Doctrine\Common\Collections\ArrayCollection;

class Entry implements EntryInterface {
	/**
	 * Primary identifier, details depend on storage layer.
	 */
	protected $id;
	
	protected $locale;
	
	/**
	 * @var EntryInterface
	 */
	protected $parent;
	
	/**
	 * @var ArrayCollection
	 */
	protected $children;
	
	/**
	 * Could be a word like "hello/bonjour/こんにちは" or a phrase like "go doing sth" or "I love my dog"
	 */
	protected $phrase;
	
	protected $phoneticSymbols;
	
	protected $definition;
	
	protected $type;
	
	protected $sense;
	
	/**
	 * A list of sample phrases/statements
	 */
	protected $samples;
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
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
	public function setLocale( $locale ) {
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
	public function setPhrase( $phrase ) {
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
	public function setPhoneticSymbols( $phoneticSymbols ) {
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
	public function setDefinition( $definition ) {
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
	public function setType( $type ) {
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
	public function setSense( $sense ) {
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
	public function setSamples( $samples ) {
		$this->samples = $samples;
	}
	
	/**
	 * @return EntryInterface
	 */
	public function getParent() {
		return $this->parent;
	}
	
	/**
	 * @param EntryInterface $parent
	 */
	public function setParent( $parent ) {
		$this->parent = $parent;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getChildren() {
		return $this->children;
	}
	
	/**
	 * @param ArrayCollection $children
	 */
	public function setChildren( $children ) {
		$this->children = $children;
	}
}