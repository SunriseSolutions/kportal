<?php

namespace AppBundle\Entity\Content\NodeLayout\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\ColumnLayout;
use AppBundle\Entity\Content\NodeLayout\GenericLayout;
use AppBundle\Entity\Content\NodeLayout\InlineLayout;
use AppBundle\Entity\Content\NodeLayout\RowLayout;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppRootLayout {
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
		$this->children      = new ArrayCollection();
		$this->rows          = new ArrayCollection();
		$this->columns       = new ArrayCollection();
		$this->inlineLayouts = new ArrayCollection();
	}
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeLayout\RowLayout", mappedBy="rootContainer", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $rows;
	
	public function addRow(RowLayout $layout) {
		$this->rows->add($layout);
		$layout->setRootContainer($this);
	}
	
	public function removeRow(RowLayout $layout) {
		$this->rows->remove($layout);
		$layout->setRootContainer(null);
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeLayout\ColumnLayout", mappedBy="rootContainer", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $columns;
	
	public function addColumn(ColumnLayout $layout) {
		$this->columns->add($layout);
		$layout->setRootContainer($this);
	}
	
	public function removeColumn(ColumnLayout $layout) {
		$this->columns->remove($layout);
		$layout->setRootContainer(null);
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeLayout\InlineLayout", mappedBy="rootContainer", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $inlineLayouts;
	
	public function addInlineLayout(InlineLayout $layout) {
		$this->inlineLayouts->add($layout);
		$layout->setRootContainer($this);
	}
	
	public function removeInlineLayout(InlineLayout $layout) {
		$this->inlineLayouts->remove($layout);
		$layout->setRootContainer(null);
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeLayout\GenericLayout", mappedBy="root", cascade={"persist","merge"}, orphanRemoval=true)
	 * @ORM\OrderBy({"position" = "ASC"})
	 */
	protected $children;
	
	public function addChild(GenericLayout $layout) {
		$this->children->add($layout);
		$layout->setRoot($this);
	}
	
	public function removeChild(GenericLayout $layout) {
		$this->children->remove($layout);
		$layout->setRoot(null);
	}
	
	/**
	 * @var ContentNode
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Content\ContentNode", inversedBy="layout")
	 * @ORM\JoinColumn(name="id_node", referencedColumnName="id", onDelete="CASCADE"))
	 */
	protected $node;
	
	/**
	 * @return ArrayCollection
	 */
	public function getChildren() {
		return $this->children;
	}
	
	/**
	 * @param ArrayCollection $children
	 */
	public function setChildren($children) {
		$this->children = $children;
	}
	
	/**
	 * @return ContentNode
	 */
	public function getNode() {
		return $this->node;
	}
	
	/**
	 * @param ContentNode $node
	 */
	public function setNode($node) {
		$this->node = $node;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getRows() {
		return $this->rows;
	}
	
	/**
	 * @param ArrayCollection $rows
	 */
	public function setRows($rows) {
		$this->rows = $rows;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getColumns() {
		return $this->columns;
	}
	
	/**
	 * @param ArrayCollection $columns
	 */
	public function setColumns($columns) {
		$this->columns = $columns;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getInlineLayouts() {
		return $this->inlineLayouts;
	}
	
	/**
	 * @param ArrayCollection $inlineLayouts
	 */
	public function setInlineLayouts($inlineLayouts) {
		$this->inlineLayouts = $inlineLayouts;
	}
}