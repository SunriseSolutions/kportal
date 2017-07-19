<?php
namespace Bean\Component\NLP\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Created by PhpStorm.
 * User: Binh
 * Date: 7/19/2017
 * Time: 11:33 AM
 */
class Sense {
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
	
	
}