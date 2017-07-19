<?php
namespace AppBundle\Entity\Dictionary;

use AppBundle\Entity\Dictionary\Base\AppEntry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="dictionary__entry")
 *
 */
class Entry extends AppEntry {


}