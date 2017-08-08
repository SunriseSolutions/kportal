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
	
}