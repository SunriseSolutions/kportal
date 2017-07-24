<?php

namespace AppBundle\Entity\H5P\ContentType\MultiChoice\Base;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceMedia;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


abstract class AppContentMultiChoice extends Content {
	
	const MACHINE_NAME = 'H5P.MultiChoice';
	const MAJOR_VERSION = 1;
	const MINOR_VERSION = 9;
	const PATCH_VERSION = 2;
	
	function __construct() {
		parent::__construct();
		// initiate default versioning
		$this->libraries = [
			[
				'machineName'  => 'H5P.Image',
				'majorVersion' => 1,
				'minorVersion' => 0,
				'patchVersion' => 28
			],
			[
				'machineName'  => 'EmbeddedJS',
				'majorVersion' => 1,
				'minorVersion' => 0,
				'patchVersion' => 4
			],
			[
				'machineName'  => 'FontAwesome',
				'majorVersion' => 4,
				'minorVersion' => 5,
				'patchVersion' => 4
			],
			[
				'machineName'  => 'Tether',
				'majorVersion' => 1,
				'minorVersion' => 0,
				'patchVersion' => 2
			],
			[
				'machineName'  => 'Drop',
				'majorVersion' => 1,
				'minorVersion' => 0,
				'patchVersion' => 2
			],
			[
				'machineName'  => 'H5P.Transition',
				'majorVersion' => 1,
				'minorVersion' => 0,
				'patchVersion' => 3
			],
			[
				'machineName'  => 'H5P.JoubelUI',
				'majorVersion' => 1,
				'minorVersion' => 2,
				'patchVersion' => 13
			],
			[
				'machineName'  => 'H5P.Question',
				'majorVersion' => 1,
				'minorVersion' => 2,
				'patchVersion' => 2
			],
			[
				'machineName'  => self::MACHINE_NAME,
				'majorVersion' => self::MAJOR_VERSION,
				'minorVersion' => self::MINOR_VERSION,
				'patchVersion' => self::PATCH_VERSION
			]
		
		];
	}
	
	/**
	 * @var MultiChoiceMedia
	 */
	protected $multichoiceMedia;
	
	/**
	 * @return MultiChoiceMedia
	 */
	public function getMultichoiceMedia() {
		return $this->multichoiceMedia;
	}
	
	/**
	 * @return array
	 */
	public function getLibraries() {
		return $this->libraries;
	}
	
	/**
	 * @param array $libraries
	 */
	public function setLibraries($libraries) {
		$this->libraries = $libraries;
	}
	
	
}