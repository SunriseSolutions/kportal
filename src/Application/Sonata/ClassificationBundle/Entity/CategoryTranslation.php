<?php
/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Sonata\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;


/**
 * @ORM\Entity
 * @ORM\Table(name="classification__category_trans",indexes={
 *      @ORM\Index(name="classification__category_trans_idx", columns={"locale", "content", "field"},
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_faq_category_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class CategoryTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * Convenient constructor
     *
     * @param string $locale
     * @param string $field
     * @param string $value
     */
//    public function __construct($locale, $field, $value)
//    {
//        $this->setLocale($locale);
//    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $description;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  string
     * @return null
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param  string
     * @return null
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}