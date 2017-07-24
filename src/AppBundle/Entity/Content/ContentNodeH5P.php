<?php
namespace AppBundle\Entity\Content;

use AppBundle\Entity\Content\Base\AppContentNode;
use AppBundle\Entity\Content\Base\AppContentNodeH5P;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__nodes_h5p_items")
 *
 */
abstract class ContentNodeH5P extends AppContentNodeH5P
{

}