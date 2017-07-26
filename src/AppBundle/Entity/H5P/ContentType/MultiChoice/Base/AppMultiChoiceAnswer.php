<?php

namespace AppBundle\Entity\H5P\ContentType\MultiChoice\Base;

use AppBundle\Entity\Content\ContentNodeH5P;
use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass
 */
abstract class AppMultiChoiceAnswer {
	
	function __construct() {
//		parent::__construct();
	}
	
	/**
	 * @var int $id
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @var ContentMultiChoice
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice", inversedBy="answers")
	 * @ORM\JoinColumn(name="id_h5p_multichoice", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $question;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $correct = false;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true, length=255)
	 */
	protected $tip;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true, length=255)
	 */
	protected $feedbackChosen;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true, length=255)
	 */
	protected $feedbackNotChosen;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true, length=255)
	 */
	protected $text;
	
	/**
	 * @return ContentMultiChoice
	 */
	public function getQuestion() {
		return $this->question;
	}
	
	/**
	 * @param ContentMultiChoice $question
	 */
	public function setQuestion($question) {
		$this->question = $question;
	}
	
	/**
	 * @return bool
	 */
	public function isCorrect() {
		return $this->correct;
	}
	
	/**
	 * @param bool $correct
	 */
	public function setCorrect($correct) {
		$this->correct = $correct;
	}
	
	/**
	 * @return string
	 */
	public function getTip() {
		return $this->tip;
	}
	
	/**
	 * @param string $tip
	 */
	public function setTip($tip) {
		$this->tip = $tip;
	}
	
	/**
	 * @return string
	 */
	public function getFeedbackChosen() {
		return $this->feedbackChosen;
	}
	
	/**
	 * @param string $feedbackChosen
	 */
	public function setFeedbackChosen($feedbackChosen) {
		$this->feedbackChosen = $feedbackChosen;
	}
	
	/**
	 * @return string
	 */
	public function getFeedbackNotChosen() {
		return $this->feedbackNotChosen;
	}
	
	/**
	 * @param string $feedbackNotChosen
	 */
	public function setFeedbackNotChosen($feedbackNotChosen) {
		$this->feedbackNotChosen = $feedbackNotChosen;
	}
	
	/**
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}
	
	/**
	 * @param string $text
	 */
	public function setText($text) {
		$this->text = $text;
	}
	
}