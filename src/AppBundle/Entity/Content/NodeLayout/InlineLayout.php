<?php

namespace AppBundle\Entity\Content\NodeLayout;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\Base\AppColumnLayout;
use AppBundle\Entity\Content\NodeLayout\Base\AppGenericLayout;
use AppBundle\Entity\Content\NodeLayout\Base\AppInlineLayout;
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
 * @ORM\Table(name="content__layout_inline")
 *
 */
class InlineLayout extends AppInlineLayout {
	
	function __construct() {
		parent::__construct();
	}
	
	
	public function buildHtml() {
		$html = '';
		/** @var ContentPiece $piece */
		foreach($this->contentPieces as $piece) {
			$html .= $piece->buildHtml();
		}
		
		return $html;
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeLayout\ContentPiece", mappedBy="layout", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $contentPieces;
	
	/**
	 * @var RootLayout
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\RootLayout",inversedBy="inlineLayouts")
	 * @ORM\JoinColumn(name="id_root_container", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $rootContainer;
	
	/**
	 * @return ArrayCollection
	 */
	public function getContentPieces() {
		return $this->contentPieces;
	}
	
	/**
	 * @param ArrayCollection $contentPieces
	 */
	public function setContentPieces($contentPieces) {
		$this->contentPieces = $contentPieces;
	}
	
}