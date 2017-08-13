<?php
namespace AppBundle\Entity\BinhLe\ThieuNhi;

use AppBundle\Entity\Content\Base\AppContentEntity;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="binhle__thieu_nhi__bang_diem")
 */
class BangDiem {
	
	const YEU = 'YEU';
	const TRUNG_BINH = 'TRUNG_BINH';
	const KHA = 'KHA';
	const GIOI = 'GIOI';
	
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
	 * @var PhanBo
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\BinhLe\ThieuNhi\PhanBo",inversedBy="bangDiem")
	 * @ORM\JoinColumn(name="id_phan_bo", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$phanBo;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $cc9;
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $cc10;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $cc11;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $cc12;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $cc1;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $cc2;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $cc3;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $cc4;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $cc5;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $tbCCTerm1;
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $quizTerm1;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $midTerm1;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $finalTerm1;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $tbTerm1;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $tbCCTerm2;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $quizTerm2;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $midTerm2;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $finalTerm2;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $tbTerm2;
	
	/**
	 * @var  float
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $tbYear;
	
	/**
	 * @var  integer
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $sundayTicketTerm1;
	
	/**
	 * @var  integer
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $sundayTicketTerm2;
	
	/**
	 * @var  integer
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $sundayTickets;
	
	/**
	 * @var  boolean
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $awarded;
	
	/**
	 * @var  boolean
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $gradeRetention;
	
	/**
	 * @var  string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $category;
	
	/**
	 * @var  string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $remarks;
	
	/**
	 * @return PhanBo
	 */
	public function getPhanBo() {
		return $this->phanBo;
	}
	
	/**
	 * @param PhanBo $phanBo
	 */
	public function setPhanBo($phanBo) {
		$this->phanBo = $phanBo;
	}
	
	/**
	 * @return float
	 */
	public function getCc9() {
		return $this->cc9;
	}
	
	/**
	 * @param float $cc9
	 */
	public function setCc9($cc9) {
		$this->cc9 = $cc9;
	}
	
	/**
	 * @return float
	 */
	public function getCc10() {
		return $this->cc10;
	}
	
	/**
	 * @param float $cc10
	 */
	public function setCc10($cc10) {
		$this->cc10 = $cc10;
	}
	
	/**
	 * @return float
	 */
	public function getCc11() {
		return $this->cc11;
	}
	
	/**
	 * @param float $cc11
	 */
	public function setCc11($cc11) {
		$this->cc11 = $cc11;
	}
	
	/**
	 * @return float
	 */
	public function getCc12() {
		return $this->cc12;
	}
	
	/**
	 * @param float $cc12
	 */
	public function setCc12($cc12) {
		$this->cc12 = $cc12;
	}
	
	/**
	 * @return float
	 */
	public function getCc1() {
		return $this->cc1;
	}
	
	/**
	 * @param float $cc1
	 */
	public function setCc1($cc1) {
		$this->cc1 = $cc1;
	}
	
	/**
	 * @return float
	 */
	public function getCc2() {
		return $this->cc2;
	}
	
	/**
	 * @param float $cc2
	 */
	public function setCc2($cc2) {
		$this->cc2 = $cc2;
	}
	
	/**
	 * @return float
	 */
	public function getCc3() {
		return $this->cc3;
	}
	
	/**
	 * @param float $cc3
	 */
	public function setCc3($cc3) {
		$this->cc3 = $cc3;
	}
	
	/**
	 * @return float
	 */
	public function getCc4() {
		return $this->cc4;
	}
	
	/**
	 * @param float $cc4
	 */
	public function setCc4($cc4) {
		$this->cc4 = $cc4;
	}
	
	/**
	 * @return float
	 */
	public function getCc5() {
		return $this->cc5;
	}
	
	/**
	 * @param float $cc5
	 */
	public function setCc5($cc5) {
		$this->cc5 = $cc5;
	}
	
	/**
	 * @return float
	 */
	public function getQuizTerm1() {
		return $this->quizTerm1;
	}
	
	/**
	 * @param float $quizTerm1
	 */
	public function setQuizTerm1($quizTerm1) {
		$this->quizTerm1 = $quizTerm1;
	}
	
	/**
	 * @return float
	 */
	public function getMidTerm1() {
		return $this->midTerm1;
	}
	
	/**
	 * @param float $midTerm1
	 */
	public function setMidTerm1($midTerm1) {
		$this->midTerm1 = $midTerm1;
	}
	
	/**
	 * @return float
	 */
	public function getFinalTerm1() {
		return $this->finalTerm1;
	}
	
	/**
	 * @param float $finalTerm1
	 */
	public function setFinalTerm1($finalTerm1) {
		$this->finalTerm1 = $finalTerm1;
	}
	
	/**
	 * @return float
	 */
	public function getQuizTerm2() {
		return $this->quizTerm2;
	}
	
	/**
	 * @param float $quizTerm2
	 */
	public function setQuizTerm2($quizTerm2) {
		$this->quizTerm2 = $quizTerm2;
	}
	
	/**
	 * @return float
	 */
	public function getMidTerm2() {
		return $this->midTerm2;
	}
	
	/**
	 * @param float $midTerm2
	 */
	public function setMidTerm2($midTerm2) {
		$this->midTerm2 = $midTerm2;
	}
	
	/**
	 * @return float
	 */
	public function getFinalTerm2() {
		return $this->finalTerm2;
	}
	
	/**
	 * @param float $finalTerm2
	 */
	public function setFinalTerm2($finalTerm2) {
		$this->finalTerm2 = $finalTerm2;
	}
	
	/**
	 * @return int
	 */
	public function getSundayTicketTerm1() {
		return $this->sundayTicketTerm1;
	}
	
	/**
	 * @param int $sundayTicketTerm1
	 */
	public function setSundayTicketTerm1($sundayTicketTerm1) {
		$this->sundayTicketTerm1 = $sundayTicketTerm1;
	}
	
	/**
	 * @return int
	 */
	public function getSundayTicketTerm2() {
		return $this->sundayTicketTerm2;
	}
	
	/**
	 * @param int $sundayTicketTerm2
	 */
	public function setSundayTicketTerm2($sundayTicketTerm2) {
		$this->sundayTicketTerm2 = $sundayTicketTerm2;
	}
	
	/**
	 * @return int
	 */
	public function getSundayTickets() {
		return $this->sundayTickets;
	}
	
	/**
	 * @param int $sundayTickets
	 */
	public function setSundayTickets($sundayTickets) {
		$this->sundayTickets = $sundayTickets;
	}
	
	/**
	 * @return bool
	 */
	public function isAwarded() {
		return $this->awarded;
	}
	
	/**
	 * @param bool $awarded
	 */
	public function setAwarded($awarded) {
		$this->awarded = $awarded;
	}
	
	/**
	 * @return bool
	 */
	public function isGradeRetention() {
		return $this->gradeRetention;
	}
	
	/**
	 * @param bool $gradeRetention
	 */
	public function setGradeRetention($gradeRetention) {
		$this->gradeRetention = $gradeRetention;
	}
	
	/**
	 * @return string
	 */
	public function getCategory() {
		return $this->category;
	}
	
	/**
	 * @param string $category
	 */
	public function setCategory($category) {
		$this->category = $category;
	}
	
	/**
	 * @return string
	 */
	public function getRemarks() {
		return $this->remarks;
	}
	
	/**
	 * @param string $remarks
	 */
	public function setRemarks($remarks) {
		$this->remarks = $remarks;
	}
	
	
	/**
	 * @return float
	 */
	public function getTbTerm1() {
		return $this->tbTerm1;
	}
	
	/**
	 * @param float $tbTerm1
	 */
	public function setTbTerm1($tbTerm1) {
		$this->tbTerm1 = $tbTerm1;
	}
	
	/**
	 * @return float
	 */
	public function getTbTerm2() {
		return $this->tbTerm2;
	}
	
	/**
	 * @param float $tbTerm2
	 */
	public function setTbTerm2($tbTerm2) {
		$this->tbTerm2 = $tbTerm2;
	}
	
	/**
	 * @return float
	 */
	public function getTbCCTerm1() {
		return $this->tbCCTerm1;
	}
	
	/**
	 * @param float $tbCCTerm1
	 */
	public function setTbCCTerm1($tbCCTerm1) {
		$this->tbCCTerm1 = $tbCCTerm1;
	}
	
	/**
	 * @return float
	 */
	public function getTbCCTerm2() {
		return $this->tbCCTerm2;
	}
	
	/**
	 * @param float $tbCCTerm2
	 */
	public function setTbCCTerm2($tbCCTerm2) {
		$this->tbCCTerm2 = $tbCCTerm2;
	}
	
	/**
	 * @return float
	 */
	public function getTbYear() {
		return $this->tbYear;
	}
	
	/**
	 * @param float $tbYear
	 */
	public function setTbYear($tbYear) {
		$this->tbYear = $tbYear;
	}
	
	
}