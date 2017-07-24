<?php
namespace AppBundle\Entity\H5P\ContentType\MultiChoice;

use AppBundle\Entity\H5P\Base\AppContent;
use AppBundle\Entity\H5P\ContentType\MultiChoice\Base\AppContentMultiChoice;
use AppBundle\Entity\Media\Base\AppGallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="h5p__content__multichoice")
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
class ContentMultiChoice extends AppContentMultiChoice
{
    function __construct()
    {
        parent::__construct();
        
    }
	
	/**
	 * @var MultiChoiceMedia
	 * One Customer has One Cart.
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceMedia", mappedBy="content", cascade={"persist","merge"}, orphanRemoval=true)
	 */
    protected $multichoiceMedia;

}
