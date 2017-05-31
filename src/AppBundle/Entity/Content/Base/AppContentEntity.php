<?php

namespace AppBundle\Entity\Content;

use AppBundle\Entity\Content\PieceOfContent;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppContentEntity
{
    /**
     * ID_REF
     * @ORM\Id
     * @ORM\Column(type="string", length=24)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
     */
    protected $id;

    function __construct()
    {
        $this->contentPieces = new ArrayCollection();
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\PieceOfContent", mappedBy="owner", cascade={"persist","merge"})
     */
    protected $contentPieces;

    public function addContentPiece(PieceOfContent $poc)
    {
        $this->contentPieces->add($poc);
        $poc->setOwner($this);
    }

    public function removeContentPiece(PieceOfContent $poc)
    {
        $this->contentPieces->removeElement($poc);
        $poc->setOwner(null);
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $slug;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getContentPieces()
    {
        return $this->contentPieces;
    }

    /**
     * @param ArrayCollection $contentPieces
     */
    public function setContentPieces($contentPieces)
    {
        $this->contentPieces = $contentPieces;
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
	public function setSlug( $slug ) {
		$this->slug = $slug;
	}

}