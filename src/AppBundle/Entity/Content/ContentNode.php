<?php

namespace AppBundle\Entity\Content;

use AppBundle\Entity\Content\Base\AppContentNode;
use AppBundle\Entity\Content\NodeLayout\ColumnLayout;
use AppBundle\Entity\Content\NodeLayout\GenericLayout;
use AppBundle\Entity\Content\NodeLayout\InlineLayout;
use AppBundle\Entity\Content\NodeLayout\RootLayout;
use AppBundle\Entity\Content\NodeLayout\RowLayout;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__node")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"article" = "AppBundle\Entity\Content\NodeType\Article\ArticleNode", "taxonomy" = "AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyNode", "book" = "AppBundle\Entity\Content\NodeType\Book\BookNode"})
 *
 */
abstract class ContentNode extends AppContentNode {
	/**
	 * Content: 1 page or slideshow
	 * Each node should have Animation and Multidimensional
	 * Up for Out Down for Entering, Left and Right for traversing
	 * Each node must belong to a direct line
	 */
	
	/**
	 * @param RootLayout $layout
	 */
	public function setLayout($layout) {
		$this->layout = $layout;
		if( ! empty($layout)) {
			$layout->setNode($this);
		}
	}
	
	public function resetLayoutHierarchy() {
		$rows     = $this->layout->getRows();
		$columns  = $this->layout->getColumns();
		$inlines  = $this->layout->getInlineLayouts();
		$children = $this->layout->getChildren();
		/** @var GenericLayout $layout */
		foreach($rows as $layout) {
			$layout->setRoot(null);
			$layout->setRootContainer(null);
		}
		/** @var GenericLayout $layout */
		foreach($columns as $layout) {
			$layout->setRoot(null);
			$layout->setRootContainer(null);
		}
		/** @var GenericLayout $layout */
		foreach($inlines as $layout) {
			$layout->setRoot(null);
			$layout->setRootContainer(null);
		}
		/** @var GenericLayout $layout */
		foreach($children as $layout) {
			$layout->setRoot(null);
			$layout->setRootContainer(null);
		}
	}
	
	public function addColumn(ColumnLayout $column) {
		$this->layout->addColumn($column);
	}
	
	public function removeColumn(ColumnLayout $column) {
		$this->layout->removeColumn($column);
	}
	
	public function setColumns($columns) {
		$this->layout->setColumns($columns);
	}
	
	public function getColumns() {
		return $this->layout->getColumns();
	}
	
	
	public function addRow(RowLayout $row) {
		$this->layout->addRow($row);
	}
	
	public function removeRow(ColumnLayout $row) {
		$this->layout->removeRow($row);
	}
	
	public function setRows($rows) {
		$this->layout->setRows($rows);
	}
	
	public function getRows() {
		return $this->layout->getRows();
	}
	
	
	public function addInlineLayout(InlineLayout $layout) {
		$this->layout->addInlineLayout($layout);
	}
	
	public function removeInlineLayout(InlineLayout $layout) {
		$this->layout->removeInlineLayout($layout);
	}
	
	public function setInlineLayouts($layouts) {
		$this->layout->setInlineLayouts($layouts);
	}
	
	public function getInlineLayouts() {
		return $this->layout->getInlineLayouts();
	}
}