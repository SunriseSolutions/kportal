<?php

namespace AppBundle\Entity\BinhLe\ThieuNhi;

use AppBundle\Entity\Content\Base\AppContentEntity;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="binhle__thieu_nhi__doi_nhom_giao_ly")
 */
class DoiNhomGiaoLy {
	
	/**
	 * @var string
	 * @ORM\Id
	 * @ORM\Column(type="string")
	 */
	protected $id;
	
	
	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	function __construct() {
		$this->phanBoHangNam        = new ArrayCollection();
		$this->cacTruongPhuTrachDoi = new ArrayCollection();
	}
	
	public function generateId() {
		$this->id = $this->number . '-' . $this->chiDoan->getId();
	}
	
	/**
	 * @var ChiDoan
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan", inversedBy="cacDoiNhomGiaoLy", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_chi_doan", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $chiDoan;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\PhanBo", mappedBy="doiNhomGiaoLy", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $phanBoHangNam;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi", mappedBy="doiNhomGiaoLy", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $cacTruongPhuTrachDoi;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $hoanTatBangDiemHK1 = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $duocDuyetBangDiemHK1 = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $hoanTatBangDiemHK2 = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $duocDuyetBangDiemHK2 = false;

	/**
	 * @var integer
	 * @ORM\Column(type="integer")
	 */
	protected $number;
	
	/**
	 * @return ChiDoan
	 */
	public function getChiDoan() {
		return $this->chiDoan;
	}
	
	/**
	 * @param ChiDoan $chiDoan
	 */
	public function setChiDoan($chiDoan) {
		$this->chiDoan = $chiDoan;
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
	
	/**
	 * @return ArrayCollection
	 */
	public function getCacTruongPhuTrachDoi() {
		return $this->cacTruongPhuTrachDoi;
	}
	
	/**
	 * @param ArrayCollection $cacTruongPhuTrachDoi
	 */
	public function setCacTruongPhuTrachDoi($cacTruongPhuTrachDoi) {
		$this->cacTruongPhuTrachDoi = $cacTruongPhuTrachDoi;
	}
	
	/**
	 * @return bool
	 */
	public function isHoanTatBangDiemHK1() {
		return $this->hoanTatBangDiemHK1;
	}
	
	/**
	 * @param bool $hoanTatBangDiemHK1
	 */
	public function setHoanTatBangDiemHK1($hoanTatBangDiemHK1) {
		$this->hoanTatBangDiemHK1 = $hoanTatBangDiemHK1;
	}
	
	/**
	 * @return bool
	 */
	public function isHoanTatBangDiemHK2() {
		return $this->hoanTatBangDiemHK2;
	}
	
	/**
	 * @param bool $hoanTatBangDiemHK2
	 */
	public function setHoanTatBangDiemHK2($hoanTatBangDiemHK2) {
		$this->hoanTatBangDiemHK2 = $hoanTatBangDiemHK2;
	}
	
	/**
	 * @return bool
	 */
	public function isDuocDuyetBangDiemHK1() {
		return $this->duocDuyetBangDiemHK1;
	}
	
	/**
	 * @param bool $duocDuyetBangDiemHK1
	 */
	public function setDuocDuyetBangDiemHK1($duocDuyetBangDiemHK1) {
		$this->duocDuyetBangDiemHK1 = $duocDuyetBangDiemHK1;
	}
	
	/**
	 * @return bool
	 */
	public function isDuocDuyetBangDiemHK2() {
		return $this->duocDuyetBangDiemHK2;
	}
	
	/**
	 * @param bool $duocDuyetBangDiemHK2
	 */
	public function setDuocDuyetBangDiemHK2($duocDuyetBangDiemHK2) {
		$this->duocDuyetBangDiemHK2 = $duocDuyetBangDiemHK2;
	}
}