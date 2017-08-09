<?php
namespace AppBundle\Entity\Content\ContentEntity;

use AppBundle\Entity\Content\ContentEntity\Base\AppIndividualEntity;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__entity__individual")
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
class IndividualEntity extends AppIndividualEntity
{
    function __construct()
    {
        parent::__construct();
        
    }
	
	/**
	 * @var User
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="individualEntity")
	 * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
	 */
	protected $owner;
}
