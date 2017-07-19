<?php
namespace Bean\Component\Dictionary\Model\Base;

use Doctrine\Common\Collections\ArrayCollection;

interface EntryInterface {
	/**
	 * @return mixed
	 */
	public function getId();
	
	/**
	 * @param mixed $id
	 */
	public function setId( $id );
	
	/**
	 * @return mixed
	 */
	public function getLocale();
	
	/**
	 * @param mixed $locale
	 */
	public function setLocale( $locale );
	
	/**
	 * @return mixed
	 */
	public function getPhrase();
	
	/**
	 * @param mixed $phrase
	 */
	public function setPhrase( $phrase );
	
	/**
	 * @return mixed
	 */
	public function getPhoneticSymbols();
	
	/**
	 * @param mixed $phoneticSymbols
	 */
	public function setPhoneticSymbols( $phoneticSymbols );
	
	/**
	 * @return mixed
	 */
	public function getDefinition();
	
	/**
	 * @param mixed $definition
	 */
	public function setDefinition( $definition );
	
	/**
	 * @return mixed
	 */
	public function getBriefComment();
	
	/**
	 * @param mixed $commnent
	 */
	public function setBriefComment( $commnent );
	
	/**
	 * @return mixed
	 */
	public function getType();
	
	/**
	 * @param mixed $type
	 */
	public function setType( $type );
	
	/**
	 * @return mixed
	 */
	public function getSense();
	
	/**
	 * @param mixed $sense
	 */
	public function setSense( $sense );
	
	/**
	 * @return mixed
	 */
	public function getSamples();
	
	/**
	 * @param mixed $samples
	 */
	public function setSamples( $samples );
	
	/**
	 * @param EntryInterface $entry
	 */
	public function setUserEntry( $entry );
	
	/**
	 * @return EntryInterface
	 */
	public function getUserEntry();
	
	/**
	 * @param ArrayCollection $usages
	 */
	public function setUsages( $usages );
	
	/**
	 * @return ArrayCollection
	 */
	public function getUsages();
}