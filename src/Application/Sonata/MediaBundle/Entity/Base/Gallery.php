<?php
namespace Application\Sonata\MediaBundle\Entity\Base;

use Application\Sonata\ClassificationBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;


class Gallery extends BaseGallery
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var integer
     */
    protected $position;

    /**
     * @var ArrayCollection $children
     */
    protected $children;

    /**
     * @var Category
     */
    protected $parent;

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param ArrayCollection $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }


}