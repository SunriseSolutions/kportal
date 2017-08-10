<?php

namespace AppBundle\Entity\BinhLe\ThieuNhi;

use AppBundle\Entity\Content\Base\AppContentEntity;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="binhle__thieu_nhi__thanh_vien")
 */
class ThanhVien {
	
	public static $christianNames = [
		'PHÊ-RÔ'   => 'Peter',
		'PHAO-LÔ'  => 'Paul',
		'GIUSE'    => 'Joseph',
		'TÊ-RÊ-SA' => 'Therese',
		'MARIA'    => 'Mary',
		'ANNA'     => 'Anne',
	];
	
	const PHAN_DOAN_CHIEN = 'PHAN_DOAN_CHIEN';
	const PHAN_DOAN_AU = 'PHAN_DOAN_AU';
	const PHAN_DOAN_THIEU = 'PHAN_DOAN_THIEU';
	const PHAN_DOAN_NGHIA = 'PHAN_DOAN_NGHIA';
	const PHAN_DOAN_TONG_DO = 'PHAN_DOAN_TONG_DO';
	const DU_TRUONG = 'DU_TRUONG';
	const HUYNH_TRUONG = 'HUYNH_TRUONG';
	
	public static $danhSachPhanDoan = [
		self::PHAN_DOAN_CHIEN   => self::PHAN_DOAN_CHIEN,
		self::PHAN_DOAN_AU      => self::PHAN_DOAN_AU,
		self::PHAN_DOAN_THIEU   => self::PHAN_DOAN_THIEU,
		self::PHAN_DOAN_NGHIA   => self::PHAN_DOAN_NGHIA,
		self::PHAN_DOAN_TONG_DO => self::PHAN_DOAN_TONG_DO,
	];
	
	public static $danhSachChiDoan = [
		4  => self::PHAN_DOAN_CHIEN,
		5  => self::PHAN_DOAN_CHIEN,
		6  => self::PHAN_DOAN_CHIEN,
		7  => self::PHAN_DOAN_AU,
		8  => self::PHAN_DOAN_AU,
		9  => self::PHAN_DOAN_AU,
		10 => self::PHAN_DOAN_THIEU,
		11 => self::PHAN_DOAN_THIEU,
		12 => self::PHAN_DOAN_THIEU,
		13 => self::PHAN_DOAN_NGHIA,
		14 => self::PHAN_DOAN_NGHIA,
		15 => self::PHAN_DOAN_NGHIA,
		16 => self::PHAN_DOAN_TONG_DO,
		17 => self::PHAN_DOAN_TONG_DO,
		18 => self::PHAN_DOAN_TONG_DO,
		19 => self::DU_TRUONG,
		20 => self::HUYNH_TRUONG,
	];
	
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\PhanBo", mappedBy="thanhVien", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $phanBoHangNam;
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $dob;
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $namHoc;
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $chiDoan;
	
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
	protected $soDienThoai;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $soDienThoaiMe;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $soDienThoaiBo;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $soDienThoaiNha;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $diaChiThuongTru;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $diaChiTamTru;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $phanDoan;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true,length=512)
	 */
	protected $name;
	
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
	
	/**
	 * @return int
	 */
	public function getChiDoan() {
		return $this->chiDoan;
	}
	
	/**
	 * @param int $chiDoan
	 */
	public function setChiDoan($chiDoan) {
		$this->chiDoan = $chiDoan;
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
	 * @return string
	 */
	public function getFirstname() {
		return $this->firstname;
	}
	
	/**
	 * @param string $firstname
	 */
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}
	
	/**
	 * @return string
	 */
	public function getChristianname() {
		return $this->christianname;
	}
	
	/**
	 * @param string $christianname
	 */
	public function setChristianname($christianname) {
		$this->christianname = $christianname;
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
	 * @return string
	 */
	public function getMiddlename() {
		return $this->middlename;
	}
	
	/**
	 * @param string $middlename
	 */
	public function setMiddlename($middlename) {
		$this->middlename = $middlename;
	}
	
	/**
	 * @return string
	 */
	public function getLastname() {
		return $this->lastname;
	}
	
	/**
	 * @param string $lastname
	 */
	public function setLastname($lastname) {
		$this->lastname = $lastname;
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
	 * @return string
	 */
	public function getSoDienThoai() {
		return $this->soDienThoai;
	}
	
	/**
	 * @param string $soDienThoai
	 */
	public function setSoDienThoai($soDienThoai) {
		$this->soDienThoai = $soDienThoai;
	}
	
	/**
	 * @return string
	 */
	public function getSoDienThoaiMe() {
		return $this->soDienThoaiMe;
	}
	
	/**
	 * @param string $soDienThoaiMe
	 */
	public function setSoDienThoaiMe($soDienThoaiMe) {
		$this->soDienThoaiMe = $soDienThoaiMe;
	}
	
	/**
	 * @return string
	 */
	public function getSoDienThoaiBo() {
		return $this->soDienThoaiBo;
	}
	
	/**
	 * @param string $soDienThoaiBo
	 */
	public function setSoDienThoaiBo($soDienThoaiBo) {
		$this->soDienThoaiBo = $soDienThoaiBo;
	}
	
	/**
	 * @return string
	 */
	public function getSoDienThoaiNha() {
		return $this->soDienThoaiNha;
	}
	
	/**
	 * @param string $soDienThoaiNha
	 */
	public function setSoDienThoaiNha($soDienThoaiNha) {
		$this->soDienThoaiNha = $soDienThoaiNha;
	}
	
	/**
	 * @return string
	 */
	public function getDiaChiThuongTru() {
		return $this->diaChiThuongTru;
	}
	
	/**
	 * @param string $diaChiThuongTru
	 */
	public function setDiaChiThuongTru($diaChiThuongTru) {
		$this->diaChiThuongTru = $diaChiThuongTru;
	}
	
	/**
	 * @return string
	 */
	public function getDiaChiTamTru() {
		return $this->diaChiTamTru;
	}
	
	/**
	 * @param string $diaChiTamTru
	 */
	public function setDiaChiTamTru($diaChiTamTru) {
		$this->diaChiTamTru = $diaChiTamTru;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getDob() {
		return $this->dob;
	}
	
	/**
	 * @param \DateTime $dob
	 */
	public function setDob($dob) {
		$this->dob = $dob;
	}
	
	/**
	 * @return array
	 */
	public static function getChristianNames() {
		return self::$christianNames;
	}
	
	/**
	 * @param array $christianNames
	 */
	public static function setChristianNames($christianNames) {
		self::$christianNames = $christianNames;
	}
	
	/**
	 * @return array
	 */
	public static function getDanhSachPhanDoan() {
		return self::$danhSachPhanDoan;
	}
	
	/**
	 * @param array $danhSachPhanDoan
	 */
	public static function setDanhSachPhanDoan($danhSachPhanDoan) {
		self::$danhSachPhanDoan = $danhSachPhanDoan;
	}
	
	/**
	 * @return array
	 */
	public static function getDanhSachChiDoan() {
		return self::$danhSachChiDoan;
	}
	
	/**
	 * @param array $danhSachChiDoan
	 */
	public static function setDanhSachChiDoan($danhSachChiDoan) {
		self::$danhSachChiDoan = $danhSachChiDoan;
	}
	
	/**
	 * @return int
	 */
	public function getNamHoc() {
		return $this->namHoc;
	}
	
	/**
	 * @param int $namHoc
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
	
	
}