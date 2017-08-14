<?php

namespace AppBundle\Entity\BinhLe\ThieuNhi;

use AppBundle\Entity\Content\Base\AppContentEntity;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="binhle__thieu_nhi__nam_hoc")
 */
class NamHoc {
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="integer")
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
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan", mappedBy="namHoc", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $chiDoan;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false} )
	 */
	protected $started = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false} )
	 */
	protected $enabled = false;
	
	/** @var float
	 * @ORM\Column(type="float", options={"default":5} )
	 */
	protected $diemTB = 5;
	
	/** @var float
	 * @ORM\Column(type="float", options={"default":7.5} )
	 */
	protected $diemKha = 7.5;
	
	/** @var float
	 * @ORM\Column(type="float", options={"default":8.75} )
	 */
	protected $diemGioi = 8.75;
	
	/** @var integer
	 * @ORM\Column(type="integer", options={"default":15} )
	 */
	protected $phieuLenLop = 15;
	
	/** @var integer
	 * @ORM\Column(type="integer", options={"default":25} )
	 */
	protected $phieuKhenThuong = 25;
	
	/**
	 * @return mixed
	 */
	public function getEnabled() {
		return $this->enabled;
	}
	
	/**
	 * @param mixed $enabled
	 */
	public function setEnabled($enabled) {
		$this->enabled = $enabled;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getChiDoan() {
		return $this->chiDoan;
	}
	
	/**
	 * @param ArrayCollection $chiDoan
	 */
	public function setChiDoan($chiDoan) {
		$this->chiDoan = $chiDoan;
	}
	
	/**
	 * @return float
	 */
	public function getDiemTB() {
		return $this->diemTB;
	}
	
	/**
	 * @param float $diemTB
	 */
	public function setDiemTB($diemTB) {
		$this->diemTB = $diemTB;
	}
	
	/**
	 * @return float
	 */
	public function getDiemKha() {
		return $this->diemKha;
	}
	
	/**
	 * @param float $diemKha
	 */
	public function setDiemKha($diemKha) {
		$this->diemKha = $diemKha;
	}
	
	/**
	 * @return float
	 */
	public function getDiemGioi() {
		return $this->diemGioi;
	}
	
	/**
	 * @param float $diemGioi
	 */
	public function setDiemGioi($diemGioi) {
		$this->diemGioi = $diemGioi;
	}
	
	/**
	 * @return int
	 */
	public function getPhieuLenLop() {
		return $this->phieuLenLop;
	}
	
	/**
	 * @param int $phieuLenLop
	 */
	public function setPhieuLenLop($phieuLenLop) {
		$this->phieuLenLop = $phieuLenLop;
	}
	
	/**
	 * @return int
	 */
	public function getPhieuKhenThuong() {
		return $this->phieuKhenThuong;
	}
	
	/**
	 * @param int $phieuKhenThuong
	 */
	public function setPhieuKhenThuong($phieuKhenThuong) {
		$this->phieuKhenThuong = $phieuKhenThuong;
	}
	
	/**
	 * @return bool
	 */
	public function isStarted() {
		return $this->started;
	}
	
	/**
	 * @param bool $started
	 */
	public function setStarted($started) {
		$this->started = $started;
	}
	
}