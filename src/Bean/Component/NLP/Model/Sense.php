<?php
namespace Bean\Component\NLP\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Sense {
	
	/**
	 * @var string
	 */
	protected $abstract;
	
	/**
	 * @var string
	 */
	protected $data;
	
	/**
	 * @var ArrayCollection
	 */
	protected $entries;
	
	/**
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}
	
	/**
	 * @param mixed $data
	 */
	public function setData($data) {
		$this->data = $data;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getEntries() {
		return $this->entries;
	}
	
	/**
	 * @param ArrayCollection $entries
	 */
	public function setEntries($entries) {
		$this->entries = $entries;
	}
	
	/**
	 * @return string
	 */
	public function getAbstract() {
		return $this->abstract;
	}
	
	/**
	 * @param string $abstract
	 */
	public function setAbstract($abstract) {
		$this->abstract = $abstract;
	}
}