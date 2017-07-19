<?php

namespace AppBundle\Entity\Location;

use AppBundle\Entity\Location\Base\AppGeolocation;
use Bean\Bundle\LocationBundle\Model\Geolocation as GeolocationModel;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="location__geolocation")
 *
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_jobs",
 *         parameters = { "user" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {} },
 * )
 *
 */
class Geolocation extends AppGeolocation {

}