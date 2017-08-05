<?php

namespace AppBundle\Entity\Content\NodeLayout;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\Base\AppGenericLayout;
use AppBundle\Entity\Content\NodeLayout\Base\AppRootLayout;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__layout_root")
 *
 */
class RootLayout extends AppRootLayout {
	
	function __construct() {
		parent::__construct();
	}
	
	public function buildHtml() {
		$html     = '';
		$children = $this->children;
		/** @var GenericLayout $child */
		foreach($children as $child) {
			$html .= $child->buildHtml();
		}
		
		return $html;
	}
}