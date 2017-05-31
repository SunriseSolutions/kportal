<?php
/**
 * Created by PhpStorm.
 * User: Binh
 * Date: 12/30/2016
 * Time: 12:02 PM
 */

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
	 * @param EntryInterface $parent
	 */
	public function setParent( $parent );
	
	/**
	 * @return EntryInterface
	 */
	public function getParent();
	
	/**
	 * @param ArrayCollection $children
	 */
	public function setChildren( $children );
	
	/**
	 * @return ArrayCollection
	 */
	public function getChildren();
}