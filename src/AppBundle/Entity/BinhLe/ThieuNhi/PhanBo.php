<?php

namespace AppBundle\Entity\BinhLe\ThieuNhi;

use AppBundle\Entity\Content\Base\AppContentEntity;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

/**
 * @ORM\Entity
 * @ORM\Table(name="binhle__thieu_nhi__phan_bo")
 */
class PhanBo {
	/**
	 * ID_REF
	 * @var string
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
		$this->cacTruongPhuTrachDoi = new ArrayCollection();
		$this->createdAt            = new \DateTime();
	}
	
	public function setVaiTro() {
		$tv                = $this->thanhVien;
		$this->huynhTruong = $tv->isHuynhTruong();
		$this->thieuNhi    = $tv->isThieuNhi();
		
		if($this->huynhTruong && $this->thieuNhi) {
			throw new InvalidArgumentException();
		}
		
		$this->xuDoanTruong   = $tv->isXuDoanTruong();
		$this->xuDoanPhoNoi   = $tv->isXuDoanPhoNoi();
		$this->xuDoanPhoNgoai = $tv->isXuDoanPhoNgoai();
		
	}
	
	public function getCacPhanBoThieuNhiPhuTrach() {
		$cacTruongPT   = $this->cacTruongPhuTrachDoi;
		$phanBoHangNam = new ArrayCollection();
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($cacTruongPT as $truongPT) {
			$phanBoHangNam = new ArrayCollection(array_merge($phanBoHangNam->toArray(), $truongPT->getDoiNhomGiaoLy()->getPhanBoHangNam()->toArray()));
		}
		
		if($phanBoHangNam->count() > 0) {
			$array       = $phanBoHangNam->toArray();
			$phanBoArray = [];
			$sortedArray = [];
			$returnArray = [];
			/** @var PhanBo $phanBoItem */
			foreach($array as $phanBoItem) {
				$firstName                           = $phanBoItem->getThanhVien()->getFirstname();
				$sortedArray[ $phanBoItem->getId() ] = $firstName;
				$phanBoArray[ $phanBoItem->getId() ] = $phanBoItem;
//				$manager->persist();
				$phanBoItem->createBangDiem();
			}
			
			$collator = new \Collator('vi_VN');
			$collator->asort($sortedArray);
			foreach($sortedArray as $id => $name) {
				$returnArray[] = $phanBoArray[ $id ];
			}
			$phanBoHangNam = new ArrayCollection(($returnArray));
		}
		
		return $phanBoHangNam;
	}
	
	/**
	 * @param $hocKy
	 *
	 * @return bool
	 */
	public function coTheNopBangDiem($hocKy) {
		$hocKy = intval($hocKy);
		if($hocKy === 1 && $this->isHoanTatBangDiemHK1()) {
			return false;
		}
		
		if($hocKy === 2 && $this->isHoanTatBangDiemHK2()) {
			return false;
		}
		
		return true;
	}
	
	public function quanLy(PhanBo $phanBo) {
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($this->cacTruongPhuTrachDoi as $truongPT) {
			$phanBoHangNam = $truongPT->getDoiNhomGiaoLy()->getPhanBoHangNam();
			/** @var PhanBo $phanBoThieuNhi */
			foreach($phanBoHangNam as $phanBoThieuNhi) {
				if($phanBoThieuNhi === $phanBo) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * @return BangDiem
	 */
	public function createBangDiem() {
		if(empty($this->bangDiem)) {
			$this->bangDiem = new BangDiem();
			$this->bangDiem->setPhanBo($this);
		}
		
		return $this->bangDiem;
	}
	
	public function hoanTatBangDiemHK1() {
		if( ! $this->coTheNopBangDiem(1)) {
			return false;
		}
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($this->cacTruongPhuTrachDoi as $truongPT) {
			$truongPT->getDoiNhomGiaoLy()->setHoanTatBangDiemHK1(true);
		}
	}
	
	public function isHoanTatBangDiemHK1() {
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($this->cacTruongPhuTrachDoi as $truongPT) {
			if(empty($truongPT->getDoiNhomGiaoLy()->isHoanTatBangDiemHK1())) {
				return false;
			};
		}
		
		return true;
	}
	
	public function hoanTatBangDiemHK2() {
		if( ! $this->coTheNopBangDiem(2)) {
			return false;
		}
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($this->cacTruongPhuTrachDoi as $truongPT) {
			$truongPT->getDoiNhomGiaoLy()->setHoanTatBangDiemHK2(true);
		}
	}
	
	public function isHoanTatBangDiemHK2() {
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($this->cacTruongPhuTrachDoi as $truongPT) {
			if(empty($truongPT->getDoiNhomGiaoLy()->isHoanTatBangDiemHK2())) {
				return false;
			};
		}
		
		return true;
	}
	
	/**
	 * @param BangDiem $bangDiem
	 */
	public function setBangDiem($bangDiem) {
		$this->bangDiem = $bangDiem;
		$bangDiem->setPhanBo($this);
	}
	
	
	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	public function getBangDiemTruoc() {
		$namTruoc = $this->chiDoan->getNamHoc()->getNamTruoc();
		
	}
	
	/**
	 * @param ChiDoan $chiDoanObj
	 */
	public function setChiDoan($chiDoanObj) {
		$this->chiDoan = $chiDoanObj;
		if( ! empty($chiDoanObj)) {
			$this->phanDoan = ThanhVien::$danhSachChiDoan[ $chiDoanObj->getNumber() ];
		}
	}
	
	public function clearCacTruongPhuTrachDoi() {
		/** @var TruongPhuTrachDoi $truongDoi */
		foreach($this->cacTruongPhuTrachDoi as $truongDoi) {
			$truongDoi->setPhanBoHangNam(null);
		}
		$this->cacTruongPhuTrachDoi->clear();
	}
	
	
	/**
	 * @var DoiNhomGiaoLy
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy", inversedBy="phanBoHangNam", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_doi_nhom_giao_ly", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $doiNhomGiaoLy;
	
	/**
	 * @var ChiDoan
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan",inversedBy="phanBoHangNam", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_chi_doan", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$chiDoan;
	
	/**
	 * @var NamHoc
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\NamHoc",inversedBy="phanBoHangNam", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_nam_hoc", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$namHoc;
	
	/**
	 * @var ThanhVien
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien",inversedBy="phanBoHangNam")
	 * @ORM\JoinColumn(name="id_thanh_vien", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$thanhVien;
	
	/**
	 * @var BangDiem
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\BangDiem", mappedBy="phanBo", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $bangDiem;
	
	
	/**
	 * @var PhanBo
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\PhanBo", mappedBy="phanBoTruoc", cascade={"persist","merge"})
	 */
	protected $phanBoSau;
	
	/**
	 * @var PhanBo
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\PhanBo", inversedBy="phanBoSau", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_phan_bo_truoc", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $phanBoTruoc;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi", mappedBy="phanBoHangNam", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $cacTruongPhuTrachDoi;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\HienDien", mappedBy="thieuNhi", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $diemDanh;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\HienDien", mappedBy="huynhTruong", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $diemDanhThieuNhi;
	
	/** @var \DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $createdAt;
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer", options={"default":0})
	 */
	protected $tienQuyDong = 0;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $daDongQuy = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $duBi = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $thieuNhi = true;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $duTruong = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $huynhTruong = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $chiDoanTruong = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $phanDoanTruong = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $xuDoanTruong = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $xuDoanPhoNoi = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $xuDoanPhoNgoai = false;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $phanDoan;
	
	/**
	 * @return ThanhVien
	 */
	public function getThanhVien() {
		return $this->thanhVien;
	}
	
	/**
	 * @param ThanhVien $thanhVien
	 */
	public function setThanhVien($thanhVien) {
		$this->thanhVien = $thanhVien;
	}
	
	/**
	 * @return BangDiem
	 */
	public function getBangDiem() {
		return $this->bangDiem;
	}
	
	/**
	 * @return bool
	 */
	public function isDuBi() {
		return $this->duBi;
	}
	
	/**
	 * @param bool $duBi
	 */
	public function setDuBi($duBi) {
		$this->duBi = $duBi;
	}
	
	/**
	 * @return bool
	 */
	public function isThieuNhi() {
		return $this->thieuNhi;
	}
	
	/**
	 * @param bool $thieuNhi
	 */
	public function setThieuNhi($thieuNhi) {
		$this->thieuNhi = $thieuNhi;
	}
	
	/**
	 * @return bool
	 */
	public function isDuTruong() {
		return $this->duTruong;
	}
	
	/**
	 * @param bool $duTruong
	 */
	public function setDuTruong($duTruong) {
		$this->duTruong = $duTruong;
	}
	
	/**
	 * @return bool
	 */
	public function isHuynhTruong() {
		return $this->huynhTruong;
	}
	
	/**
	 * @param bool $huynhTruong
	 */
	public function setHuynhTruong($huynhTruong) {
		$this->huynhTruong = $huynhTruong;
	}
	
	/**
	 * @return bool
	 */
	public function isChiDoanTruong() {
		return $this->chiDoanTruong;
	}
	
	/**
	 * @param bool $chiDoanTruong
	 */
	public function setChiDoanTruong($chiDoanTruong) {
		$this->chiDoanTruong = $chiDoanTruong;
	}
	
	/**
	 * @return bool
	 */
	public function isPhanDoanTruong() {
		return $this->phanDoanTruong;
	}
	
	/**
	 * @param bool $phanDoanTruong
	 */
	public function setPhanDoanTruong($phanDoanTruong) {
		$this->phanDoanTruong = $phanDoanTruong;
	}
	
	/**
	 * @return bool
	 */
	public function isXuDoanTruong() {
		return $this->xuDoanTruong;
	}
	
	/**
	 * @param bool $xuDoanTruong
	 */
	public function setXuDoanTruong($xuDoanTruong) {
		$this->xuDoanTruong = $xuDoanTruong;
	}
	
	/**
	 * @return bool
	 */
	public function isXuDoanPhoNoi() {
		return $this->xuDoanPhoNoi;
	}
	
	/**
	 * @param bool $xuDoanPhoNoi
	 */
	public function setXuDoanPhoNoi($xuDoanPhoNoi) {
		$this->xuDoanPhoNoi = $xuDoanPhoNoi;
	}
	
	/**
	 * @return bool
	 */
	public function isXuDoanPhoNgoai() {
		return $this->xuDoanPhoNgoai;
	}
	
	/**
	 * @param bool $xuDoanPhoNgoai
	 */
	public function setXuDoanPhoNgoai($xuDoanPhoNgoai) {
		$this->xuDoanPhoNgoai = $xuDoanPhoNgoai;
	}
	
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
	 * @return ChiDoan
	 */
	public function getChiDoan() {
		return $this->chiDoan;
	}
	
	/**
	 * @return PhanBo
	 */
	public function getPhanBoSau() {
		return $this->phanBoSau;
	}
	
	/**
	 * @param PhanBo $phanBoSau
	 */
	public function setPhanBoSau($phanBoSau) {
		$this->phanBoSau = $phanBoSau;
	}
	
	/**
	 * @return PhanBo
	 */
	public function getPhanBoTruoc() {
		return $this->phanBoTruoc;
	}
	
	/**
	 * @param PhanBo $phanBoTruoc
	 */
	public function setPhanBoTruoc($phanBoTruoc) {
		$this->phanBoTruoc = $phanBoTruoc;
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
	 * @return DoiNhomGiaoLy
	 */
	public function getDoiNhomGiaoLy() {
		return $this->doiNhomGiaoLy;
	}
	
	/**
	 * @param DoiNhomGiaoLy $doiNhomGiaoLy
	 */
	public function setDoiNhomGiaoLy($doiNhomGiaoLy) {
		$this->doiNhomGiaoLy = $doiNhomGiaoLy;
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
	public function isDaDongQuy() {
		return $this->daDongQuy;
	}
	
	/**
	 * @param bool $daDongQuy
	 */
	public function setDaDongQuy($daDongQuy) {
		$this->daDongQuy = $daDongQuy;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getDiemDanh() {
		return $this->diemDanh;
	}
	
	/**
	 * @param ArrayCollection $diemDanh
	 */
	public function setDiemDanh($diemDanh) {
		$this->diemDanh = $diemDanh;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getDiemDanhThieuNhi() {
		return $this->diemDanhThieuNhi;
	}
	
	/**
	 * @param ArrayCollection $diemDanhThieuNhi
	 */
	public function setDiemDanhThieuNhi($diemDanhThieuNhi) {
		$this->diemDanhThieuNhi = $diemDanhThieuNhi;
	}
	
	/**
	 * @return int
	 */
	public function getTienQuyDong() {
		return $this->tienQuyDong;
	}
	
	/**
	 * @param int $tienQuyDong
	 */
	public function setTienQuyDong($tienQuyDong) {
		$this->tienQuyDong = $tienQuyDong;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}
}