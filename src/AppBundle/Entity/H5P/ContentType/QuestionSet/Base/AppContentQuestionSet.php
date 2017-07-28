<?php

namespace AppBundle\Entity\H5P\ContentType\QuestionSet\Base;

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

abstract class AppContentQuestionSet extends Content {
	
	const PROGRESS_DOTS = 'dots';
	const PROGRESS_TEXTUAL = 'textual';
	
	const MACHINE_NAME = 'H5P.QuestionSet';
	const MAJOR_VERSION = 1;
	const MINOR_VERSION = 12;
	const PATCH_VERSION = 2;
	
	function __construct() {
		parent::__construct();
		// initiate default versioning
		$this->setupLibraries();
	}
	
	public function setupLibraries() {
		if(empty($this->libraries)) {
			$this->libraries = [
				[
					'machineName'  => 'EmbeddedJS',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4,
				
				],
				[
					'machineName'  => 'FontAwesome',
					'majorVersion' => 4,
					'minorVersion' => 5,
					'patchVersion' => 4,
				
				],
				[
					'machineName'  => 'Tether',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 2,
				
				],
				[
					'machineName'  => 'Drop',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 2,
				
				],
				[
					'machineName'  => 'H5P.Transition',
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
					'machineName'  => 'H5P.MultiChoice',
					'majorVersion' => 1,
					'minorVersion' => 9,
					'patchVersion' => 2,
				
				],
				[
					'machineName'  => 'H5P.Image',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 28,
				
				],
				[
					'machineName'  => 'H5P.AdvancedText',
					'majorVersion' => 1,
					'minorVersion' => 1,
					'patchVersion' => 2,
				
				],
				[
					'machineName'  => 'jQuery.ui',
					'majorVersion' => 1,
					'minorVersion' => 10,
					'patchVersion' => 19,
				
				],
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
					'machineName'    => 'Tether',
					'majorVersion'   => 1,
					'minorVersion'   => 0,
					'patchVersion'   => 2,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'Drop',
					'majorVersion'   => 1,
					'minorVersion'   => 0,
					'patchVersion'   => 2,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5P.Transition',
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
					'machineName'    => 'H5P.AdvancedText',
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
				[
					'machineName'  => 'H5P.DragQuestion',
					'majorVersion' => 1,
					'minorVersion' => 9,
					'patchVersion' => 0,
				
				],
				[
					'machineName'  => 'flowplayer',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 5,
				
				],
				[
					'machineName'  => 'H5P.Video',
					'majorVersion' => 1,
					'minorVersion' => 3,
					'patchVersion' => 4,
				
				],
				[
					'machineName'    => 'H5PEditor.QuestionSetTextualEditor',
					'majorVersion'   => 1,
					'minorVersion'   => 2,
					'patchVersion'   => 0,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				[
					'machineName'    => 'H5PEditor.VerticalTabs',
					'majorVersion'   => 1,
					'minorVersion'   => 3,
					'patchVersion'   => 2,
					'dependencyType' => Dependency::TYPE_EDITOR
				],
				$this->getLibraryVersion()
			];
		}
		
		return $this->libraries;
	}
	
	public function getLibraryVersion() {
		return [
			'machineName'  => self::MACHINE_NAME,
			'majorVersion' => self::MAJOR_VERSION,
			'minorVersion' => self::MINOR_VERSION,
			'patchVersion' => self::PATCH_VERSION
		];
	}
	
	
	
}