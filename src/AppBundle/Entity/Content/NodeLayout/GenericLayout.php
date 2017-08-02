<?php

namespace AppBundle\Entity\Content\NodeLayout;

use AppBundle\Entity\Content\ContentNode;
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
 * @ORM\Table(name="content__layout_generic")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"column" = "AppBundle\Entity\Content\NodeLayout\ColumnLayout", "row" = "AppBundle\Entity\Content\NodeLayout\RowLayout", "inline" = "AppBundle\Entity\Content\NodeLayout\InlineLayout"})
 *
 */
abstract class GenericLayout extends AppGenericLayout {
	
	function __construct() {
		parent::__construct();
	}
	
	public abstract function buildHtml();
	
	public function buildChildHtml() {
		$html     = '';
		$children = $this->children;
		/** @var GenericLayout $child */
		foreach($children as $child) {
			$html .= $child->buildHtml();
		}
		
		return $html;
	}
}