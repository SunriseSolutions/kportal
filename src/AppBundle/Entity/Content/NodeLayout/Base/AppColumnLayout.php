<?php

namespace AppBundle\Entity\Content\NodeLayout\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\GenericLayout;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


abstract class AppColumnLayout extends GenericLayout {
	
	const SCREEN_PHONE = 1;
	const SCREEN_TABLET = 2;
	const SCREEN_DESKTOP = 3;
	const SCREEN_LARGER_DESKTOP = 4;
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * @var integer
	 */
	protected $span;
	
	/**
	 * @var integer
	 */
	protected $screenSize;
	
	/**
	 * @return int
	 */
	public function getSpan() {
		return $this->span;
	}
	
	/**
	 * @param int $span
	 */
	public function setSpan($span) {
		$this->span = $span;
	}
	
	/**
	 * @return int
	 */
	public function getScreenSize() {
		return $this->screenSize;
	}
	
	/**
	 * @param int $screenSize
	 */
	public function setScreenSize($screenSize) {
		$this->screenSize = $screenSize;
	}
}