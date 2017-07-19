<?php
namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Organisation\Base\AppEmployment;
use AppBundle\Entity\Organisation\Base\AppOrganisation;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="organisation__employment")
 */
class Employment extends AppEmployment {
	
}