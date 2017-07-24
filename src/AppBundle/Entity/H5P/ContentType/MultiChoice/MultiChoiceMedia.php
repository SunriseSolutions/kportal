<?php

namespace AppBundle\Entity\H5P\ContentType\MultiChoice;

use AppBundle\Entity\Content\ContentNodeH5P;
use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\ContentType\MultiChoice\Base\AppMultiChoiceMedia;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="h5p__content__multichoice_media")
 *
 */
class MultiChoiceMedia extends AppMultiChoiceMedia {
	
	const MACHINE_NAME = 'H5P.Image';
	const MAJOR_VERSION = 1;
	const MINOR_VERSION = 0;
	const PATCH_VERSION = 8;
	
	/**
	 * @var array
	 */
	protected $libraries;
	
	function __construct() {
		parent::__construct();
		// initiate default versioning
		$this->libraries = [
		
		];
	}
	
}