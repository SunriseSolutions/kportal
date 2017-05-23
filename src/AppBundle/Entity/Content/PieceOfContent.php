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

}