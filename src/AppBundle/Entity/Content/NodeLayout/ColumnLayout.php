<?php

namespace AppBundle\Entity\Content\NodeLayout;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\Base\AppColumnLayout;
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
 * @ORM\Table(name="content__layout_column")
 *
 */
class ColumnLayout extends AppColumnLayout {
	
	function __construct() {
		parent::__construct();
	}
	
	public function buildHtml() {
		return '';
	}
	
	/**
	 * @var RootLayout
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\RootLayout",inversedBy="columns")
	 * @ORM\JoinColumn(name="id_root_container", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $rootContainer;
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer",options={"default":1})
	 */
	protected $span = 1;
}