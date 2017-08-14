<?php

namespace AppBundle\Entity\BinhLe\ThieuNhi;

use AppBundle\Entity\Content\Base\AppContentEntity;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="binhle__thieu_nhi__chi_doan")
 */
class ChiDoan {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="string")
	 */
	protected $id;
	
	public function generateId(){
		$this->id = $this->name.'-'.$this->namHoc->getId();
	}
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/** @var array
	 * @ORM\Column(type="attribute_array")
	 */
	protected $cotDiemBiLoaiBo = array();
	
	/**
	 * @var NamHoc
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\NamHoc",inversedBy="chiDoan")
	 * @ORM\JoinColumn(name="nam_hoc", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$namHoc;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\PhanBo", mappedBy="chiDoan", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $phanBoHangNam;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $name;
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $number;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $phanDoan;
	
	/**
	 * @return string
	 */
	public function getPhanDoan() {
		return $this->phanDoan;
	}
	
	/**
	 * @param string $phanDoan
	 */
	public function setPhanDoan($phanDoan) {
		$this->phanDoan = $phanDoan;
	}
	
	
	/**
	 * @return ArrayCollection
	 */
	public function getPhanBoHangNam() {
		return $this->phanBoHangNam;
	}
	
	/**
	 * @param ArrayCollection $phanBoHangNam
	 */
	public function setPhanBoHangNam($phanBoHangNam) {
		$this->phanBoHangNam = $phanBoHangNam;
	}
	
	/**
	 * @return NamHoc
	 */
	public function getNamHoc() {
		return $this->namHoc;
	}
	
	/**
	 * @param NamHoc $namHoc
	 */
	public function setNamHoc($namHoc) {
		$this->namHoc = $namHoc;
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @return array
	 */
	public function getCotDiemBiLoaiBo() {
		return $this->cotDiemBiLoaiBo;
	}
	
	/**
	 * @param array $cotDiemBiLoaiBo
	 */
	public function setCotDiemBiLoaiBo($cotDiemBiLoaiBo) {
		$this->cotDiemBiLoaiBo = $cotDiemBiLoaiBo;
	}
	
	/**
	 * @return int
	 */
	public function getNumber() {
		return $this->number;
	}
	
	/**
	 * @param int $number
	 */
	public function setNumber($number) {
		$this->number = $number;
	}
	
	
}