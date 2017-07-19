<?php
namespace AppBundle\Entity\Content;

use AppBundle\Entity\Content\Base\AppContentNode;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__node")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"article" = "AppBundle\Entity\Content\ArticleNode", "blog" = "AppBundle\Entity\Content\BlogNode", "book" = "AppBundle\Entity\Content\BookNode"})
 *
 */
abstract class ContentNode extends AppContentNode
{
    /**
     * Content: 1 page or slideshow
     * Each node should have Animation and Multidimensional
     * Up for Out Down for Entering, Left and Right for traversing
     * Each node must belong to a direct line
     */

}