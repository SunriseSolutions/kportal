<?php

namespace AppBundle\Entity\BinhLe\ThieuNhi;

use AppBundle\Entity\Content\Base\AppContentEntity;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="binhle__thieu_nhi__thanh_vien")
 */
class ThanhVien {
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true,length=255)
	 */
	protected $firstname;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true,length=255)
	 */
	protected $middlename;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true,length=255)
	 */
	protected $lastname;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true,length=255)
	 */
	protected $christianname;
}