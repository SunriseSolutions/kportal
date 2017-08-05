<?php
namespace AppBundle\Entity\Content\NodeLayout;

use AppBundle\Entity\Content\Base\AppContentNode;
use AppBundle\Entity\Content\NodeLayout\Base\AppContentPieceH5P;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__pieces_h5p_items")
 *
 */
class ContentPieceH5P extends AppContentPieceH5P
{

}