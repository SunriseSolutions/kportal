<?php

namespace AppBundle\Entity\NLP;

use AppBundle\Entity\Dictionary\Base\AppSense;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nlp__sense")
 */
class Sense extends AppSense
{

}