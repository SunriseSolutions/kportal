<?php

namespace AppBundle\Entity\BinhLe\ThieuNhi;

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
	
	/** @var integer */
	private $soThieuNhi = null;
	/** @var integer */
	private $soThieuNhiDongQuy = null;
	
	public function getPhanTramDongQuy() {
		return ($this->getSoThieuNhiDongQuy() / $this->getSoThieuNhi()) * 100;
	}
	
	public function getSoThieuNhiDongQuy() {
		if($this->soThieuNhiDongQuy === null) {
			$this->soThieuNhi = 0;
			$counter          = 0;
			/** @var PhanBo $phanBo */
			foreach($this->phanBoHangNam as $phanBo) {
				if($phanBo->getThanhVien()->isEnabled()) {
					$this->soThieuNhi ++;
					if($phanBo->isDaDongQuy()) {
						$counter ++;
					}
				}
			}
			$this->soThieuNhiDongQuy = $counter;
		}
		
		return $this->soThieuNhiDongQuy;
	}
	
	public function getSoThieuNhi() {
		if($this->soThieuNhi === null) {
			$counter = 0;
			/** @var PhanBo $phanBo */
			foreach($this->phanBoHangNam as $phanBo) {
				if($phanBo->getThanhVien()->isEnabled()) {
					$counter ++;
				}
			}
			$this->soThieuNhi = $counter;
		}
		
		return $this->soThieuNhi;
	}
	
	function __construct() {
		$this->phanBoHangNam    = new ArrayCollection();
		$this->cacDoiNhomGiaoLy = new ArrayCollection();
	}
	
	public function generateId() {
		$this->id = $this->number . '-' . $this->namHoc->getId();
	}
	
	private $phanBoHangNamSorted = false;
	
	/**
	 * @return ArrayCollection
	 */
	public
	function getPhanBoHangNam() {
		if( ! $this->phanBoHangNamSorted) {
			$array       = $this->phanBoHangNam->toArray();
			$phanBoArray = [];
			$sortedArray = [];
			$returnArray = [];
			/** @var PhanBo $phanBo */
			foreach($array as $phanBo) {
				$firstName                       = $phanBo->getThanhVien()->getFirstname();
				$sortedArray[ $phanBo->getId() ] = $firstName;
				$phanBoArray[ $phanBo->getId() ] = $phanBo;
			}
			$this->phanBoHangNamSorted = true;
			$collator                  = new \Collator('vi_VN');
//			natcasesort()
			$collator->asort($sortedArray);
			foreach($sortedArray as $id => $name) {
				$returnArray[] = $phanBoArray[ $id ];
			}
			$this->phanBoHangNam = new ArrayCollection(($returnArray));
		}
		
		return $this->phanBoHangNam;
	}
	
	public function chiaTruongPhuTrachVaoCacDoi($doi1, $doi2, $doi3, PhanBo $phanBo) {
		if($phanBo->getChiDoan()->getId() !== $this->id) {
			return false;
		}
		$phanBo->clearCacTruongPhuTrachDoi();
		$dngl1     = $this->getDoiNhomGiaoLy($doi1);
		$dngl2     = $this->getDoiNhomGiaoLy($doi2);
		$dngl3     = $this->getDoiNhomGiaoLy($doi3);
		$truongPT1 = $this->chiaTruongPhuTrach($dngl1, $phanBo);
		$truongPT2 = $this->chiaTruongPhuTrach($dngl2, $phanBo);
		$truongPT3 = $this->chiaTruongPhuTrach($dngl3, $phanBo);
		
		return ! empty($truongPT1) || ! empty($truongPT2) || ! empty($truongPT3);
	}
	
	/**
	 * @param DoiNhomGiaoLy $dngl
	 * @param PhanBo        $phanBo
	 *
	 * @return TruongPhuTrachDoi|bool
	 */
	public function chiaTruongPhuTrach(DoiNhomGiaoLy $dngl = null, PhanBo $phanBo) {
		if( ! empty($dngl)) {
			$truongPhuTrach = new TruongPhuTrachDoi();
			$truongPhuTrach->setPhanBoHangNam($phanBo);
			$truongPhuTrach->setDoiNhomGiaoLy($dngl);
			$truongPhuTrach->generateId();
			
			$dngl->getCacTruongPhuTrachDoi()->add($truongPhuTrach);
			$phanBo->getCacTruongPhuTrachDoi()->add($truongPhuTrach);
			
			return $truongPhuTrach;
		}
		
		return false;
	}
	
	/**
	 * @param integer $doi
	 *
	 * @return DoiNhomGiaoLy
	 */
	public function getDoiNhomGiaoLy($doi, $autoCreate = true) {
		if(empty($doi)) {
			return null;
		}
		/** @var DoiNhomGiaoLy $dngl */
		foreach($this->cacDoiNhomGiaoLy as $dngl) {
			if($dngl->getNumber() === $doi) {
				return $dngl;
			}
		}
		if(empty($autoCreate)) {
			return null;
		}
		$dngl = new DoiNhomGiaoLy();
		$dngl->setNumber($doi);
		$dngl->setChiDoan($this);
		$this->cacDoiNhomGiaoLy->add($dngl);
		$dngl->generateId();
		
		return $dngl;
	}
	
	/**
	 * @return mixed
	 */
	public
	function getId() {
		return $this->id;
	}
	
	/** @var array
	 * @ORM\Column(type="json")
	 */
	protected
		$cotDiemBiLoaiBo = array();
	
	/**
	 * @var NamHoc
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\NamHoc",inversedBy="chiDoan")
	 * @ORM\JoinColumn(name="nam_hoc", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$namHoc;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy", mappedBy="chiDoan", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected
		$cacDoiNhomGiaoLy;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\PhanBo", mappedBy="chiDoan", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected
		$phanBoHangNam;
	
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
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected
		$name;
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected
		$number;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected
		$phanDoan;
	
	/**
	 * @return string
	 */
	public
	function getPhanDoan() {
		return $this->phanDoan;
	}
	
	/**
	 * @param string $phanDoan
	 */
	public
	function setPhanDoan(
		$phanDoan
	) {
		$this->phanDoan = $phanDoan;
	}
	
	/**
	 * @param ArrayCollection $phanBoHangNam
	 */
	public
	function setPhanBoHangNam(
		$phanBoHangNam
	) {
		$this->phanBoHangNam = $phanBoHangNam;
	}
	
	/**
	 * @return NamHoc
	 */
	public
	function getNamHoc() {
		return $this->namHoc;
	}
	
	/**
	 * @param NamHoc $namHoc
	 */
	public
	function setNamHoc(
		$namHoc
	) {
		$this->namHoc = $namHoc;
	}
	
	/**
	 * @return string
	 */
	public
	function getName() {
		return $this->name;
	}
	
	/**
	 * @param string $name
	 */
	public
	function setName(
		$name
	) {
		$this->name = $name;
	}
	
	/**
	 * @return array
	 */
	public
	function getCotDiemBiLoaiBo() {
		return $this->cotDiemBiLoaiBo;
	}
	
	/**
	 * @param array $cotDiemBiLoaiBo
	 */
	public
	function setCotDiemBiLoaiBo(
		$cotDiemBiLoaiBo
	) {
		$this->cotDiemBiLoaiBo = $cotDiemBiLoaiBo;
	}
	
	/**
	 * @return int
	 */
	public
	function getNumber() {
		return $this->number;
	}
	
	/**
	 * @param int $number
	 */
	public
	function setNumber(
		$number
	) {
		$this->number = $number;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getCacDoiNhomGiaoLy() {
		return $this->cacDoiNhomGiaoLy;
	}
	
	/**
	 * @param ArrayCollection $cacDoiNhomGiaoLy
	 */
	public function setCacDoiNhomGiaoLy($cacDoiNhomGiaoLy) {
		$this->cacDoiNhomGiaoLy = $cacDoiNhomGiaoLy;
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