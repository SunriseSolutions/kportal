<?php

namespace AppBundle\Entity\Content\NodeType\Taxonomy\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyNode;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppTaxonomyContext {
	
	const TYPE_TAG = 'TAG';
	const TYPE_CATEGORY = 'CATEGORY';
	
	function __construct() {
		$this->taxonomies = new ArrayCollection();
		
	}
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyNode", mappedBy="context", cascade={"all"})
	 */
	protected $taxonomies;
	
	public function addTaxonomy(TaxonomyNode $item) {
		$this->taxonomies->add($item);
		$item->setContext($this);
	}
	
	public function removeTaxonomy(TaxonomyNode $item) {
		$this->taxonomies->removeElement($item);
		$item->setContext(null);
	}
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=128, nullable=true)
	 */
	protected
		$slug;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=128, nullable=true)
	 */
	protected
		$type;
	
	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
	
	/**
	 * @return ArrayCollection
	 */
	public function getTaxonomies() {
		return $this->taxonomies;
	}
	
	/**
	 * @param ArrayCollection $taxonomies
	 */
	public function setTaxonomies($taxonomies) {
		$this->taxonomies = $taxonomies;
	}
	
	/**
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}
	
	/**
	 * @param string $slug
	 */
	public function setSlug($slug) {
		$this->slug = $slug;
	}
}