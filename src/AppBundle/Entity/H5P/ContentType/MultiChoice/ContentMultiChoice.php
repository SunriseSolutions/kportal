<?php

namespace AppBundle\Entity\H5P\ContentType\MultiChoice;

use AppBundle\Entity\H5P\Base\AppContent;
use AppBundle\Entity\H5P\ContentMedia;
use AppBundle\Entity\H5P\ContentType\MultiChoice\Base\AppContentMultiChoice;
use AppBundle\Entity\Media\Base\AppGallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="h5p__content__multichoice")
 *
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_jobs",
 *         parameters = { "user" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {} },
 * )
 *
 */
class ContentMultiChoice extends AppContentMultiChoice {
	function __construct() {
		parent::__construct();
		
	}
	
//	/**
//	 * @return array
//	 */
//	public function getLibraries() {
//		$this->setupLibraries();
//
//		return $this->libraries;
//	}
	
	public function buildParameterObject() {
		$obj = new \stdClass();
		if( ! empty($this->multichoiceMedia)) {
			$obj->media = $this->multichoiceMedia->getJsonObject();
		} else {
			$obj->media = new \stdClass();
		}
		
		$obj->question = $this->questionText;
		
		$obj->answers = [];
		/** @var MultiChoiceAnswer $answer */
		foreach($this->answers as $answer) {
			$obj->answers[] = $answer->getJsonObject();
		}
		
		$obj->UI           = $this->buildUIParamObject();
		$obj->behaviour    = $this->buildBehaviourParamObject();
		$obj->confirmCheck = $this->buildConfirmCheckParamObject();
		$obj->confirmRetry = $this->buildConfirmRetryParamObject();
		
		return $obj;
	}
	
	private function buildUIParamObject() {
		$ui                     = new \stdClass();
		$ui->checkAnswerButton  = $this->checkAnswerButtonText;
		$ui->showSolutionButton = $this->showSolutionButtonText;
		$ui->tryAgainButton     = $this->tryAgainButtonText;
		$ui->tipsLabel          = $this->tipLabelText;
		$ui->scoreBarLabel      = $this->scoreBarLabelText;
		$ui->tipAvailable       = $this->tipAvailableText;
		$ui->feedbackAvailable  = $this->feedbackAvailableText;
		$ui->readFeedback       = $this->readFeedbackText;
		$ui->wrongAnswer        = $this->wrongAnswerText;
		$ui->correctAnswer      = $this->correctAnswerText;
		$ui->feedback           = $this->feedbackText;
		$ui->shouldCheck        = $this->shouldCheckText;
		$ui->shouldNotCheck     = $this->shouldNotCheckText;
		$ui->noInput            = $this->noInputText;
		$ui->correctText        = $this->correctFeedbackText;
		$ui->almostText         = $this->almostCorrectFeedbackText;
		$ui->wrongText          = $this->wrongFeedbackText;
		
		return $ui;
	}
	
	private function buildBehaviourParamObject() {
		$behaviour                             = new \stdClass();
		$behaviour->enableRetry                = $this->retryEnabled;
		$behaviour->enableSolutionsButton      = $this->solutionButtonEnabled;
		$behaviour->type                       = $this->type;
		$behaviour->singlePoint                = $this->singlePoint;
		$behaviour->randomAnswers              = $this->randomAnswers;
		$behaviour->showSolutionsRequiresInput = $this->inputRequiredToShowSolutions;
		$behaviour->disableImageZooming        = $this->imageZoomingDisabled;
		$behaviour->confirmCheckDialog         = $this->checkConfirmDialogEnabled;
		$behaviour->confirmRetryDialog         = $this->retryConfirmDialogEnabled;
		$behaviour->autoCheck                  = $this->autoCheckEnabled;
		$behaviour->passPercentage             = $this->passPercentage;
		
		return $behaviour;
	}
	
	private function buildConfirmCheckParamObject() {
		$obj               = new \stdClass();
		$obj->header       = $this->confirmCheckHeaderText;
		$obj->body         = $this->confirmCheckBodyText;
		$obj->cancelLabel  = $this->confirmCheckCancelButtonText;
		$obj->confirmLabel = $this->confirmCheckConfirmButtonText;
		
		return $obj;
	}
	
	private function buildConfirmRetryParamObject() {
		$obj = new \stdClass();
		
		$obj->header       = $this->confirmRetryHeaderText;
		$obj->body         = $this->confirmRetryBodyText;
		$obj->cancelLabel  = $this->confirmRetryCancelButtonText;
		$obj->confirmLabel = $this->confirmRetryConfirmButtonText;
		
		return $obj;
	}
	
	
	/**
	 * @param ContentMedia $multichoiceMedia
	 */
	public function setMultichoiceMedia($multichoiceMedia) {
		$this->multichoiceMedia = $multichoiceMedia;
		if( ! empty($multichoiceMedia)) {
//			$multichoiceMedia->setQuestion($this);
			if($multichoiceMedia->isImage()) {
				array_unshift($this->libraries, $multichoiceMedia->getImageLib());
			}
			
			if($multichoiceMedia->isYoutube()) {
				array_unshift($this->libraries, $multichoiceMedia->getFlowplayerLib(), $multichoiceMedia->getVidLib());
			}
		}
	}
	
	/**
	 * @var ArrayCollection
	 * One Customer has One Cart.
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceAnswer", mappedBy="question", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $answers;
	
	/**
	 * @var ContentMedia
	 * One Customer has One Cart.
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\H5P\ContentMedia", cascade={"all"}, orphanRemoval=true)
	 * @ORM\JoinColumn(name="id_content_media", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $multichoiceMedia;
	
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer", options={"default":100})
	 */
	protected $passPercentage = 100;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $retryEnabled = true;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $solutionButtonEnabled = true;
	
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $singlePoint = true;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $randomAnswers = true;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $inputRequiredToShowSolutions = true;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $imageZoomingDisabled = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $checkConfirmDialogEnabled = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $retryConfirmDialogEnabled = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $autoCheckEnabled = true;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $correctFeedbackText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $almostCorrectFeedbackText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $wrongFeedbackText;
	
	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $questionText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $type = 'auto';
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $checkAnswerButtonText;
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $showSolutionButtonText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $tryAgainButtonText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $tipLabelText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $feedbackAvailableText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $scoreBarLabelText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $tipAvailableText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $readFeedbackText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $wrongAnswerText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $correctAnswerText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $feedbackText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $shouldCheckText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $shouldNotCheckText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $noInputText;
	
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $confirmCheckHeaderText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $confirmCheckBodyText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $confirmCheckCancelButtonText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $confirmCheckConfirmButtonText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $confirmRetryHeaderText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $confirmRetryBodyText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $confirmRetryCancelButtonText;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $confirmRetryConfirmButtonText;
	
}
