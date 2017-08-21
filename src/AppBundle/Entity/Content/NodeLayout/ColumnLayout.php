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
		$childHtml = $this->buildChildHtml();
		switch($this->screenSize) {
			case self::SCREEN_LARGER_DESKTOP:
				$size = 'lg';
				break;
			case self::SCREEN_DESKTOP:
				$size = 'md';
				break;
			case self::SCREEN_TABLET:
				$size = 'sm';
				break;
			default:
				$size = 'xs';
				break;
		}
		$colClass  = 'col-' . $size . '-' . $this->span;
		$textAlign = empty($this->textAlign) ? '' : 'text-align: ' . $this->textAlign . ';';
		
		$colStyle = 'style="' . $textAlign . '"';
		$html     = '<div ' . $colStyle . ' class = "' . $colClass . '" >' . $childHtml . '</div>';
		
		return $html;
	}
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true, length=6)
	 */
	protected $textAlign;
	
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
	
	/**
	 * @var integer
	 * @ORM\Column(type="smallint",options={"default":1})
	 */
	protected $screenSize = 1;
}