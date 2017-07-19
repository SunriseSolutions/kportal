<?php

namespace AppBundle\Entity\Organisation\Base;

use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\User;
use Bean\Component\Organisation\Model\Employment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/** @ORM\MappedSuperclass */
class AppEmployment extends Employment {
	function __construct() {
	}
	
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 */
	protected
		$id;
	
}