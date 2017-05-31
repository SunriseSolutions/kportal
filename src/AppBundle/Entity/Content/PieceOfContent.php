<?php
namespace AppBundle\Entity\Content;

use AppBundle\Entity\Content\Base\AppPieceOfContent;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__piece")
 */
class PieceOfContent extends AppPieceOfContent
{
    /**
     * Content: 1 page or slideshow
     * Each piece should have Animation and Multidimensional
     * Up for Out Down for Entering, Left and Right for traversing
     * Each PoC must belong to a direct line
     */

}