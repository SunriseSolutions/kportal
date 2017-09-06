<?php
namespace AppBundle\Entity\NLP\Sense;

use AppBundle\Entity\NLP\Sense\Base\AppSense;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nlp__sense")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"head" = "AppBundle\Entity\NLP\Sense\HeadSense"})
 *
 */
abstract class Sense extends AppSense
{

}