<?php
namespace AppBundle\Entity\Content\Base;

use AppBundle\Entity\Content\ArticleVocabEntry;
use AppBundle\Entity\Content\BlogItem;
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
	}
	
	/**
	 * @var ArrayCollection
	 */
	protected $blogItems;
	
	public function addBlogItem(BlogItem $item) {
		$this->blogItems->add($item);
		$item->setArticle($this);
	}
	
	public function removeBlogItem(BlogItem $item) {
		$this->blogItems->removeElement($item);
		$item->setArticle(null);
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
}