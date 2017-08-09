<?php

namespace AppBundle\Entity\Content\ContentPiece;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\ContentPiece\Base\AppContentPiece;
use AppBundle\Entity\Content\NodeLayout\Base\AppGenericLayout;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__piece")
 *
 */
class ContentPiece extends AppContentPiece {
	
	function __construct() {
		parent::__construct();
	}
	
	public function buildHtml() {
		return $this->content;
	}
	
	public function getRootLayout() {
		return $this->getLayout()->getRootContainer();
	}
	
}