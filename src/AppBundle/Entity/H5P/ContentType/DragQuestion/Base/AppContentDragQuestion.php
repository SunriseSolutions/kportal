<?php

namespace AppBundle\Entity\H5P\ContentType\DragQuestion\Base;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceAnswer;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceMedia;
use AppBundle\Entity\H5P\Dependency;
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
		// initiate default versioning
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
					'patchVersion' => 4,
				],
				[
					'machineName'  => 'Tether', //// 9
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 2,
				],
				[
					'machineName'  => 'Drop', /// 1
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 2,
				],
				[
					'machineName'  => 'H5P.Transition', /// 8
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 3,
				],
				[
					'machineName'  => 'H5P.JoubelUI',
					'majorVersion' => 1,
					'minorVersion' => 2,
					'patchVersion' => 13,
				],
				[
					'machineName'  => 'H5P.Question',
					'majorVersion' => 1,
					'minorVersion' => 2,
					'patchVersion' => 2,
				],
				[
					'machineName'  => 'jQuery.ui',
					'majorVersion' => 1,
					'minorVersion' => 10,
					'patchVersion' => 19,
				],
				//////////////// for editor dependencyType
				[
					'machineName'    => 'FontAwesome',
					'majorVersion'   => 4,
					'minorVersion'   => 5,
					'patchVersion'   => 4,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5P.Image',
					'majorVersion'   => 1,
					'minorVersion'   => 0,
					'patchVersion'   => 28,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'Tether', //// 9
					'majorVersion'   => 1,
					'minorVersion'   => 0,
					'patchVersion'   => 2,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'Drop', /// 1
					'majorVersion'   => 1,
					'minorVersion'   => 0,
					'patchVersion'   => 2,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5P.Transition', /// 8
					'majorVersion'   => 1,
					'minorVersion'   => 0,
					'patchVersion'   => 3,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5P.JoubelUI',
					'majorVersion'   => 1,
					'minorVersion'   => 2,
					'patchVersion'   => 13,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5P.AdvancedText', //////
					'majorVersion'   => 1,
					'minorVersion'   => 1,
					'patchVersion'   => 2,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5P.DragNDrop',
					'majorVersion'   => 1,
					'minorVersion'   => 1,
					'patchVersion'   => 4,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5P.DragNResize',
					'majorVersion'   => 1,
					'minorVersion'   => 2,
					'patchVersion'   => 2,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5P.DragNBar',
					'majorVersion'   => 1,
					'minorVersion'   => 4,
					'patchVersion'   => 0,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5PEditor.Wizard',
					'majorVersion'   => 1,
					'minorVersion'   => 1,
					'patchVersion'   => 0,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'jQuery.ui',
					'majorVersion'   => 1,
					'minorVersion'   => 10,
					'patchVersion'   => 19,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5PEditor.DragQuestion',
					'majorVersion'   => 1,
					'minorVersion'   => 7,
					'patchVersion'   => 0,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				$this->getLibraryVersion()
			];
		}
		
		return $this->libraries;
	}
	
	
}