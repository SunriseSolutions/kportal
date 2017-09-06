<?php
namespace AppBundle\Entity\NLP\Sense\Base;

use AppBundle\Entity\NLP\Sense\Sense;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

abstract class AppHeadSense extends Sense {

	function __construct() {
		parent::__construct();
		
	}
	
}