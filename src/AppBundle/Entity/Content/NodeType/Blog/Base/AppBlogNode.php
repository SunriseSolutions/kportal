<?php

namespace AppBundle\Entity\Content\NodeType\Blog\Base;

use AppBundle\Entity\Content\NodeType\Blog\BlogItem;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

abstract class AppBlogNode extends ContentNode {
	
	function __construct() {
		parent::__construct();
		$this->items = new ArrayCollection();
		
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeType\Blog\BlogItem", mappedBy="blog", cascade={"all"}, orphanRemoval=true)
	 */
	protected $items;
	
	public function addItem(BlogItem $item) {
		$this->items->add($item);
		$item->setBlog($this);
	}
	
	public function removeItem(BlogItem $item) {
		$this->items->removeElement($item);
		$item->setBlog(null);
	}
}