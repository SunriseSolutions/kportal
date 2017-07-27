<?php

namespace AppBundle\Entity\H5P\ContentType\DragQuestion\Base;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceAnswer;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceMedia;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

abstract class AppContentDragQuestion extends Content {
	
	const MACHINE_NAME = 'H5P.DragQuestion';
	const MAJOR_VERSION = 1;
	const MINOR_VERSION = 9;
	const PATCH_VERSION = 0;
	
	function __construct() {
		parent::__construct();
		$this->answers = new ArrayCollection();
		// initiate default versioning
		$this->setupLibraries();
	}
	
	public function setupLibraries() {
		if(empty($this->libraries)) {
			$this->libraries = [
				[
					'machineName'  => 'H5P.AdvancedText',
					'majorVersion' => 1,
					'minorVersion' => 1,
					'patchVersion' => 2
				],
				[
					'machineName'  => 'H5P.Image',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 28
				],
				[
					'machineName'  => 'FontAwesome',
					'majorVersion' => 4,
					'minorVersion' => 5,
					'patchVersion' => 4
				],
				[
					'machineName'  => 'Tether', //// 9
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 2
				],
				[
					'machineName'  => 'Drop', /// 1
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 2
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => '',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				$this->getLibraryVersion()
			];
		}
	}
	
}