<?php

namespace AppBundle\Entity\H5P\ContentType\MultiChoice\Base;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\ContentMedia;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceAnswer;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

abstract class AppContentMultiChoice extends Content {
	
	const MACHINE_NAME = 'H5P.MultiChoice';
	const MAJOR_VERSION = 1;
	const MINOR_VERSION = 9;
	const PATCH_VERSION = 2;
	
	function __construct() {
		parent::__construct();
		$this->answers = new ArrayCollection();
	}
	
	public function setupLibraries() {
		if(empty($this->libraries)) {
			$this->libraries = [
				[
					'machineName'  => 'EmbeddedJS',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 4
				],
				[
					'machineName'  => 'FontAwesome',
					'majorVersion' => 4,
					'minorVersion' => 5,
					'patchVersion' => 4
				],
				[
					'machineName'  => 'Tether',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 2
				],
				[
					'machineName'  => 'Drop',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 2
				],
				[
					'machineName'  => 'H5P.Transition',
					'majorVersion' => 1,
					'minorVersion' => 0,
					'patchVersion' => 3
				],
				[
					'machineName'  => 'H5P.JoubelUI',
					'majorVersion' => 1,
					'minorVersion' => 2,
					'patchVersion' => 13
				],
				[
					'machineName'  => 'H5P.Question',
					'majorVersion' => 1,
					'minorVersion' => 2,
					'patchVersion' => 2
				],
				$this->getLibraryVersion()
			];
			$this->setupMultichoiceMediaLibraries();
		}
		
		return $this->libraries;
	}
	
	protected abstract function setupMultichoiceMediaLibraries();
	
	/**
	 * @var ArrayCollection
	 */
	protected $answers;
	
	public function addAnswer(MultiChoiceAnswer $answer) {
		$this->answers->add($answer);
		$answer->setQuestion($this);
	}
	
	public function removeAnswer(MultiChoiceAnswer $answer) {
		$this->answers->remove($answer);
		$answer->setQuestion(null);
	}
	
	/**
	 * @var string
	 */
	protected $questionText;
	
	/**
	 * @var ContentMedia
	 */
	protected $multichoiceMedia;
	
	//////////// behavioural settings //////////////
	
	/**
	 * @var boolean
	 */
	protected $retryEnabled = true;
	
	/**
	 * @var boolean
	 */
	protected $solutionButtonEnabled = true;
	
	/**
	 * @var string
	 */
	protected $type = 'auto';
	
	/**
	 * @var boolean
	 */
	protected $singlePoint = true;
	
	/**
	 * @var boolean
	 */
	protected $randomAnswers = true;
	
	/**
	 * @var boolean
	 */
	protected $inputRequiredToShowSolutions = true;
	
	/**
	 * @var boolean
	 */
	protected $imageZoomingDisabled = false;
	
	/**
	 * @var boolean
	 */
	protected $checkConfirmDialogEnabled = false;
	
	/**
	 * @var boolean
	 */
	protected $retryConfirmDialogEnabled = false;
	
	/**
	 * @var boolean
	 */
	protected $autoCheckEnabled = true;
	
	/**
	 * @var integer
	 */
	protected $passPercentage = 100;
	
	///////// end of behavioural settings //////////
	///
	///
	///
	///// UI Settinsg //////////////////
	/**
	 * @var string
	 */
	protected $checkAnswerButtonText;
	/**
	 * @var string
	 */
	protected $showSolutionButtonText;
	/**
	 * @var string
	 */
	protected $tryAgainButtonText;
	
	/**
	 * @var string
	 */
	protected $tipLabelText;
	
	/**
	 * @var string
	 */
	protected $feedbackAvailableText;
	
	/**
	 * @var string
	 */
	protected $scoreBarLabelText;
	
	/**
	 * @var string
	 */
	protected $tipAvailableText;
	
	/**
	 * @var string
	 */
	protected $readFeedbackText;
	/**
	 * @var string
	 */
	protected $wrongAnswerText;
	/**
	 * @var string
	 */
	protected $correctAnswerText;
	/**
	 * @var string
	 */
	protected $feedbackText;
	/**
	 * @var string
	 */
	protected $shouldCheckText;
	/**
	 * @var string
	 */
	protected $shouldNotCheckText;
	
	/**
	 * @var string
	 */
	protected $noInputText;
	
	/**
	 * @var string
	 */
	protected $correctFeedbackText;
	
	/**
	 * @var string
	 */
	protected $almostCorrectFeedbackText;
	
	/**
	 * @var string
	 */
	protected $wrongFeedbackText;
	////////////// end of UI settings ///////
	///
	/// /////////// Confirm Dialog settings //////////
	/**
	 * @var string
	 */
	protected $confirmCheckHeaderText;
	
	/**
	 * @var string
	 */
	protected $confirmCheckBodyText;
	
	/**
	 * @var string
	 */
	protected $confirmCheckCancelButtonText;
	
	/**
	 * @var string
	 */
	protected $confirmCheckConfirmButtonText;
	/**
	 * @var string
	 */
	protected $confirmRetryHeaderText;
	
	/**
	 * @var string
	 */
	protected $confirmRetryBodyText;
	
	/**
	 * @var string
	 */
	protected $confirmRetryCancelButtonText;
	
	/**
	 * @var string
	 */
	protected $confirmRetryConfirmButtonText;
	////////////// end of Confirm Dialog Settings //////////////
	
	/**
	 * @return ContentMedia
	 */
	public function getMultichoiceMedia() {
		return $this->multichoiceMedia;
	}
	
	/**
	 * @param array $libraries
	 */
	public function setLibraries($libraries) {
		$this->libraries = $libraries;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getAnswers() {
		return $this->answers;
	}
	
	/**
	 * @param ArrayCollection $answers
	 */
	public function setAnswers($answers) {
		$this->answers = $answers;
	}
	
	/**
	 * @return string
	 */
	public function getCheckAnswerButtonText() {
		return $this->checkAnswerButtonText;
	}
	
	/**
	 * @param string $checkAnswerButtonText
	 */
	public function setCheckAnswerButtonText($checkAnswerButtonText) {
		$this->checkAnswerButtonText = $checkAnswerButtonText;
	}
	
	/**
	 * @return string
	 */
	public function getShowSolutionButtonText() {
		return $this->showSolutionButtonText;
	}
	
	/**
	 * @param string $showSolutionButtonText
	 */
	public function setShowSolutionButtonText($showSolutionButtonText) {
		$this->showSolutionButtonText = $showSolutionButtonText;
	}
	
	/**
	 * @return string
	 */
	public function getTryAgainButtonText() {
		return $this->tryAgainButtonText;
	}
	
	/**
	 * @param string $tryAgainButtonText
	 */
	public function setTryAgainButtonText($tryAgainButtonText) {
		$this->tryAgainButtonText = $tryAgainButtonText;
	}
	
	/**
	 * @return string
	 */
	public function getTipLabelText() {
		return $this->tipLabelText;
	}
	
	/**
	 * @param string $tipLabelText
	 */
	public function setTipLabelText($tipLabelText) {
		$this->tipLabelText = $tipLabelText;
	}
	
	/**
	 * @return string
	 */
	public function getFeedbackAvailableText() {
		return $this->feedbackAvailableText;
	}
	
	/**
	 * @param string $feedbackAvailableText
	 */
	public function setFeedbackAvailableText($feedbackAvailableText) {
		$this->feedbackAvailableText = $feedbackAvailableText;
	}
	
	/**
	 * @return string
	 */
	public function getScoreBarLabelText() {
		return $this->scoreBarLabelText;
	}
	
	/**
	 * @param string $scoreBarLabelText
	 */
	public function setScoreBarLabelText($scoreBarLabelText) {
		$this->scoreBarLabelText = $scoreBarLabelText;
	}
	
	/**
	 * @return string
	 */
	public function getTipAvailableText() {
		return $this->tipAvailableText;
	}
	
	/**
	 * @param string $tipAvailableText
	 */
	public function setTipAvailableText($tipAvailableText) {
		$this->tipAvailableText = $tipAvailableText;
	}
	
	/**
	 * @return string
	 */
	public function getReadFeedbackText() {
		return $this->readFeedbackText;
	}
	
	/**
	 * @param string $readFeedbackText
	 */
	public function setReadFeedbackText($readFeedbackText) {
		$this->readFeedbackText = $readFeedbackText;
	}
	
	/**
	 * @return string
	 */
	public function getWrongAnswerText() {
		return $this->wrongAnswerText;
	}
	
	/**
	 * @param string $wrongAnswerText
	 */
	public function setWrongAnswerText($wrongAnswerText) {
		$this->wrongAnswerText = $wrongAnswerText;
	}
	
	/**
	 * @return string
	 */
	public function getCorrectAnswerText() {
		return $this->correctAnswerText;
	}
	
	/**
	 * @param string $correctAnswerText
	 */
	public function setCorrectAnswerText($correctAnswerText) {
		$this->correctAnswerText = $correctAnswerText;
	}
	
	/**
	 * @return string
	 */
	public function getFeedbackText() {
		return $this->feedbackText;
	}
	
	/**
	 * @param string $feedbackText
	 */
	public function setFeedbackText($feedbackText) {
		$this->feedbackText = $feedbackText;
	}
	
	/**
	 * @return string
	 */
	public function getShouldCheckText() {
		return $this->shouldCheckText;
	}
	
	/**
	 * @param string $shouldCheckText
	 */
	public function setShouldCheckText($shouldCheckText) {
		$this->shouldCheckText = $shouldCheckText;
	}
	
	/**
	 * @return string
	 */
	public function getShouldNotCheckText() {
		return $this->shouldNotCheckText;
	}
	
	/**
	 * @param string $shouldNotCheckText
	 */
	public function setShouldNotCheckText($shouldNotCheckText) {
		$this->shouldNotCheckText = $shouldNotCheckText;
	}
	
	/**
	 * @return string
	 */
	public function getNoInputText() {
		return $this->noInputText;
	}
	
	/**
	 * @param string $noInputText
	 */
	public function setNoInputText($noInputText) {
		$this->noInputText = $noInputText;
	}
	
	/**
	 * @return string
	 */
	public function getConfirmCheckHeaderText() {
		return $this->confirmCheckHeaderText;
	}
	
	/**
	 * @param string $confirmCheckHeaderText
	 */
	public function setConfirmCheckHeaderText($confirmCheckHeaderText) {
		$this->confirmCheckHeaderText = $confirmCheckHeaderText;
	}
	
	/**
	 * @return string
	 */
	public function getConfirmCheckBodyText() {
		return $this->confirmCheckBodyText;
	}
	
	/**
	 * @param string $confirmCheckBodyText
	 */
	public function setConfirmCheckBodyText($confirmCheckBodyText) {
		$this->confirmCheckBodyText = $confirmCheckBodyText;
	}
	
	/**
	 * @return string
	 */
	public function getConfirmCheckCancelButtonText() {
		return $this->confirmCheckCancelButtonText;
	}
	
	/**
	 * @param string $confirmCheckCancelButtonText
	 */
	public function setConfirmCheckCancelButtonText($confirmCheckCancelButtonText) {
		$this->confirmCheckCancelButtonText = $confirmCheckCancelButtonText;
	}
	
	/**
	 * @return string
	 */
	public function getConfirmCheckConfirmButtonText() {
		return $this->confirmCheckConfirmButtonText;
	}
	
	/**
	 * @param string $confirmCheckConfirmButtonText
	 */
	public function setConfirmCheckConfirmButtonText($confirmCheckConfirmButtonText) {
		$this->confirmCheckConfirmButtonText = $confirmCheckConfirmButtonText;
	}
	
	/**
	 * @return string
	 */
	public function getConfirmRetryHeaderText() {
		return $this->confirmRetryHeaderText;
	}
	
	/**
	 * @param string $confirmRetryHeaderText
	 */
	public function setConfirmRetryHeaderText($confirmRetryHeaderText) {
		$this->confirmRetryHeaderText = $confirmRetryHeaderText;
	}
	
	/**
	 * @return string
	 */
	public function getConfirmRetryBodyText() {
		return $this->confirmRetryBodyText;
	}
	
	/**
	 * @param string $confirmRetryBodyText
	 */
	public function setConfirmRetryBodyText($confirmRetryBodyText) {
		$this->confirmRetryBodyText = $confirmRetryBodyText;
	}
	
	/**
	 * @return string
	 */
	public function getConfirmRetryCancelButtonText() {
		return $this->confirmRetryCancelButtonText;
	}
	
	/**
	 * @param string $confirmRetryCancelButtonText
	 */
	public function setConfirmRetryCancelButtonText($confirmRetryCancelButtonText) {
		$this->confirmRetryCancelButtonText = $confirmRetryCancelButtonText;
	}
	
	/**
	 * @return string
	 */
	public function getConfirmRetryConfirmButtonText() {
		return $this->confirmRetryConfirmButtonText;
	}
	
	/**
	 * @param string $confirmRetryConfirmButtonText
	 */
	public function setConfirmRetryConfirmButtonText($confirmRetryConfirmButtonText) {
		$this->confirmRetryConfirmButtonText = $confirmRetryConfirmButtonText;
	}
	
	/**
	 * @return bool
	 */
	public function isRetryEnabled() {
		return $this->retryEnabled;
	}
	
	/**
	 * @param bool $retryEnabled
	 */
	public function setRetryEnabled($retryEnabled) {
		$this->retryEnabled = $retryEnabled;
	}
	
	/**
	 * @return bool
	 */
	public function isSolutionButtonEnabled() {
		return $this->solutionButtonEnabled;
	}
	
	/**
	 * @param bool $solutionButtonEnabled
	 */
	public function setSolutionButtonEnabled($solutionButtonEnabled) {
		$this->solutionButtonEnabled = $solutionButtonEnabled;
	}
	
	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
	/**
	 * @return bool
	 */
	public function isSinglePoint() {
		return $this->singlePoint;
	}
	
	/**
	 * @param bool $singlePoint
	 */
	public function setSinglePoint($singlePoint) {
		$this->singlePoint = $singlePoint;
	}
	
	/**
	 * @return bool
	 */
	public function isRandomAnswers() {
		return $this->randomAnswers;
	}
	
	/**
	 * @param bool $randomAnswers
	 */
	public function setRandomAnswers($randomAnswers) {
		$this->randomAnswers = $randomAnswers;
	}
	
	/**
	 * @return bool
	 */
	public function isInputRequiredToShowSolutions() {
		return $this->inputRequiredToShowSolutions;
	}
	
	/**
	 * @param bool $inputRequiredToShowSolutions
	 */
	public function setInputRequiredToShowSolutions($inputRequiredToShowSolutions) {
		$this->inputRequiredToShowSolutions = $inputRequiredToShowSolutions;
	}
	
	/**
	 * @return bool
	 */
	public function isImageZoomingDisabled() {
		return $this->imageZoomingDisabled;
	}
	
	/**
	 * @param bool $imageZoomingDisabled
	 */
	public function setImageZoomingDisabled($imageZoomingDisabled) {
		$this->imageZoomingDisabled = $imageZoomingDisabled;
	}
	
	/**
	 * @return bool
	 */
	public function isCheckConfirmDialogEnabled() {
		return $this->checkConfirmDialogEnabled;
	}
	
	/**
	 * @param bool $checkConfirmDialogEnabled
	 */
	public function setCheckConfirmDialogEnabled($checkConfirmDialogEnabled) {
		$this->checkConfirmDialogEnabled = $checkConfirmDialogEnabled;
	}
	
	/**
	 * @return bool
	 */
	public function isRetryConfirmDialogEnabled() {
		return $this->retryConfirmDialogEnabled;
	}
	
	/**
	 * @param bool $retryConfirmDialogEnabled
	 */
	public function setRetryConfirmDialogEnabled($retryConfirmDialogEnabled) {
		$this->retryConfirmDialogEnabled = $retryConfirmDialogEnabled;
	}
	
	/**
	 * @return bool
	 */
	public function isAutoCheckEnabled() {
		return $this->autoCheckEnabled;
	}
	
	/**
	 * @param bool $autoCheckEnabled
	 */
	public function setAutoCheckEnabled($autoCheckEnabled) {
		$this->autoCheckEnabled = $autoCheckEnabled;
	}
	
	/**
	 * @return int
	 */
	public function getPassPercentage() {
		return $this->passPercentage;
	}
	
	/**
	 * @param int $passPercentage
	 */
	public function setPassPercentage($passPercentage) {
		$this->passPercentage = $passPercentage;
	}
	
	/**
	 * @return string
	 */
	public function getQuestionText() {
		return $this->questionText;
	}
	
	/**
	 * @param string $questionText
	 */
	public function setQuestionText($questionText) {
		$this->questionText = $questionText;
	}
	
	/**
	 * @return string
	 */
	public function getCorrectFeedbackText() {
		return $this->correctFeedbackText;
	}
	
	/**
	 * @param string $correctFeedbackText
	 */
	public function setCorrectFeedbackText($correctFeedbackText) {
		$this->correctFeedbackText = $correctFeedbackText;
	}
	
	/**
	 * @return string
	 */
	public function getAlmostCorrectFeedbackText() {
		return $this->almostCorrectFeedbackText;
	}
	
	/**
	 * @param string $almostCorrectFeedbackText
	 */
	public function setAlmostCorrectFeedbackText($almostCorrectFeedbackText) {
		$this->almostCorrectFeedbackText = $almostCorrectFeedbackText;
	}
	
	/**
	 * @return string
	 */
	public function getWrongFeedbackText() {
		return $this->wrongFeedbackText;
	}
	
	/**
	 * @param string $wrongFeedbackText
	 */
	public function setWrongFeedbackText($wrongFeedbackText) {
		$this->wrongFeedbackText = $wrongFeedbackText;
	}
}