<?php

namespace AppBundle\Entity\Content\NodeType\Book\Base;

use AppBundle\Entity\Content\NodeType\Blog\BlogItem;
use AppBundle\Entity\Content\NodeType\Book\BookPage;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

abstract class AppBookNode extends ContentNode {
	
	function __construct() {
		parent::__construct();
		$this->pages = new ArrayCollection();
		
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeType\Book\BookPage", mappedBy="book", cascade={"all"}, orphanRemoval=true)
	 */
	protected $pages;
	
	public function addPage(BookPage $item) {
		$this->pages->add($item);
		$item->setBook($this);
	}
	
	public function removePage(BookPage $item) {
		$this->pages->removeElement($item);
		$item->setBook(null);
	}
}