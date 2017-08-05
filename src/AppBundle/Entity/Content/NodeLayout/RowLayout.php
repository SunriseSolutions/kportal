<?php

namespace AppBundle\Entity\Content\NodeLayout;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\Base\AppColumnLayout;
use AppBundle\Entity\Content\NodeLayout\Base\AppGenericLayout;
use AppBundle\Entity\Content\NodeLayout\Base\AppRowLayout;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__layout_row")
 *
 */
class RowLayout extends AppRowLayout {
	
	function __construct() {
		parent::__construct();
	}
	
	public function buildHtml() {
		$childHtml = $this->buildChildHtml();
		$rowClass  = 'row';
		$html      = '<div class = "' . $rowClass . '" >' . $childHtml . '</div>';
		
		return $html;
	}
	
	/**
	 * @var RootLayout
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\RootLayout",inversedBy="rows")
	 * @ORM\JoinColumn(name="id_root_container", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $rootContainer;
}