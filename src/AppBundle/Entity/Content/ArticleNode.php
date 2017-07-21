<?php

namespace AppBundle\Entity\Content;

use AppBundle\Entity\Content\Base\AppArticleNode;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__node__article")
 *
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_jobs",
 *         parameters = { "user" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {} },
 * )
 *
 */
class ArticleNode extends AppArticleNode {
	function __construct() {
		parent::__construct();
		
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\BlogItem", mappedBy="article", cascade={"all"}, orphanRemoval=true)
	 */
	protected $blogItems;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\ArticleVocabEntry", mappedBy="article", cascade={"all"}, orphanRemoval=true)
	 */
	protected $vocabEntries;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $topLeft;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $topMiddle;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $topRight;
	
	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $main;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $sideLeft;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $sideRight;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $bottomLeft;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $bottomRight;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $bottomMiddle;
	
}
