<?php
namespace AppBundle\Entity\Content\NodeType\Book;

use AppBundle\Entity\Content\NodeType\Article\Base\AppArticleNode;
use AppBundle\Entity\Content\NodeType\Book\Base\AppBookNode;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__node__book")
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
class BookNode extends AppBookNode
{
    function __construct()
    {
        parent::__construct();
        
    }

}
