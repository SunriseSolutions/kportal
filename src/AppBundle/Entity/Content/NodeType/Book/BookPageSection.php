<?php
namespace AppBundle\Entity\Content\NodeType\Book;

use AppBundle\Entity\Content\NodeType\Article\Base\AppArticleNode;
use AppBundle\Entity\Content\NodeType\Blog\Base\AppBlogItem;
use AppBundle\Entity\Content\Base\AppBlogNode;
use AppBundle\Entity\Content\NodeType\Book\Base\AppBookPage;
use AppBundle\Entity\Content\NodeType\Book\Base\AppBookPageSection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__node__book_page_section")
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
class BookPageSection extends AppBookPageSection
{
    function __construct()
    {
        parent::__construct();
        
    }

}
