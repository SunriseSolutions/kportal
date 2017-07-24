<?php

namespace AppBundle\Entity\H5P;

use AppBundle\Entity\H5P\Base\AppContent;
use AppBundle\Entity\Media\Base\AppGallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="h5p__content")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"multichoice" = "AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice"})
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
abstract class Content extends AppContent {
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * @var array
	 */
	protected $libraries;
	
	public function initiateDependencies(array $libraryObjs) {
		foreach($libraryObjs as $key => $lib) {
			$contentLibrary = new ContentLibrary();
			$contentLibrary->setContent($this);
			$contentLibrary->setLibrary($lib);
			$contentLibrary->setPosition($key + 1);
			
			$this->addContentLibrary($contentLibrary);
		}
	}
	
}
