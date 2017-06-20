<?php
namespace AppBundle\Entity\Content;

use AppBundle\Entity\Content\Base\AppContentNode;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__node")
 */
class ContentNode extends AppContentNode
{
    /**
     * Content: 1 page or slideshow
     * Each node should have Animation and Multidimensional
     * Up for Out Down for Entering, Left and Right for traversing
     * Each node must belong to a direct line
     */

}