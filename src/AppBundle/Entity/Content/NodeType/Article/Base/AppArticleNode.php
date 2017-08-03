<?php

namespace AppBundle\Entity\Content\NodeType\Article\Base;

use AppBundle\Entity\Content\NodeLayout\RootLayout;
use AppBundle\Entity\Content\NodeType\Article\ArticleVocabEntry;
use AppBundle\Entity\Content\NodeType\Blog\BlogItem;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

abstract class AppArticleNode extends ContentNode {
	
	function __construct() {
		parent::__construct();
		$this->blogItems = new ArrayCollection();
		$this->setLayout(new RootLayout());
		
	}
	
	/**
	 * @var ArrayCollection
	 */
	protected $vocabEntries;
	
	public function addVocabEntry(ArticleVocabEntry $item) {
		$this->vocabEntries->add($item);
		$item->setArticle($this);
	}
	
	public function removeVocabEntry(ArticleVocabEntry $item) {
		$this->vocabEntries->removeElement($item);
		$item->setArticle(null);
	}
	
	
	/**
	 * @var string
	 */
	protected $topLeft;
	
	/**
	 * @var string
	 */
	protected $topMiddle;
	
	/**
	 * @var string
	 */
	protected $topRight;
	
	/**
	 * @var string
	 */
	protected $main;
	
	/**
	 * @var string
	 */
	protected $sideLeft;
	
	/**
	 * @var string
	 */
	protected $sideRight;
	
	/**
	 * @var string
	 */
	protected $bottomLeft;
	
	/**
	 * @var string
	 */
	protected $bottomRight;
	
	/**
	 * @var string
	 */
	protected $bottomMiddle;
	
	/**
	 * @return string
	 */
	public function getTopLeft() {
		return $this->topLeft;
	}
	
	/**
	 * @param string $topLeft
	 */
	public function setTopLeft($topLeft) {
		$this->topLeft = $topLeft;
	}
	
	/**
	 * @return string
	 */
	public function getTopMiddle() {
		return $this->topMiddle;
	}
	
	/**
	 * @param string $topMiddle
	 */
	public function setTopMiddle($topMiddle) {
		$this->topMiddle = $topMiddle;
	}
	
	/**
	 * @return string
	 */
	public function getTopRight() {
		return $this->topRight;
	}
	
	/**
	 * @param string $topRight
	 */
	public function setTopRight($topRight) {
		$this->topRight = $topRight;
	}
	
	/**
	 * @return string
	 */
	public function getMain() {
		return $this->main;
	}
	
	/**
	 * @param string $main
	 */
	public function setMain($main) {
		$this->main = $main;
	}
	
	/**
	 * @return string
	 */
	public function getSideLeft() {
		return $this->sideLeft;
	}
	
	/**
	 * @param string $sideLeft
	 */
	public function setSideLeft($sideLeft) {
		$this->sideLeft = $sideLeft;
	}
	
	/**
	 * @return string
	 */
	public function getSideRight() {
		return $this->sideRight;
	}
	
	/**
	 * @param string $sideRight
	 */
	public function setSideRight($sideRight) {
		$this->sideRight = $sideRight;
	}
	
	/**
	 * @return string
	 */
	public function getBottomLeft() {
		return $this->bottomLeft;
	}
	
	/**
	 * @param string $bottomLeft
	 */
	public function setBottomLeft($bottomLeft) {
		$this->bottomLeft = $bottomLeft;
	}
	
	/**
	 * @return string
	 */
	public function getBottomRight() {
		return $this->bottomRight;
	}
	
	/**
	 * @param string $bottomRight
	 */
	public function setBottomRight($bottomRight) {
		$this->bottomRight = $bottomRight;
	}
	
	/**
	 * @return string
	 */
	public function getBottomMiddle() {
		return $this->bottomMiddle;
	}
	
	/**
	 * @param string $bottomMiddle
	 */
	public function setBottomMiddle($bottomMiddle) {
		$this->bottomMiddle = $bottomMiddle;
	}
	
	
	/**
	 * @return ArrayCollection
	 */
	public function getBlogItems() {
		return $this->blogItems;
	}
	
	/**
	 * @param ArrayCollection $blogItems
	 */
	public function setBlogItems($blogItems) {
		$this->blogItems = $blogItems;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getVocabEntries() {
		return $this->vocabEntries;
	}
	
	/**
	 * @param ArrayCollection $vocabEntries
	 */
	public function setVocabEntries($vocabEntries) {
		$this->vocabEntries = $vocabEntries;
	}
	
}