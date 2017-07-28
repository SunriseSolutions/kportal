<?php

namespace AppBundle\Entity\H5P\ContentType\QuestionSet;

use AppBundle\Entity\H5P\ContentType\QuestionSet\Base\AppContentQuestionSet;

use AppBundle\Entity\H5P\Base\AppContent;
use AppBundle\Entity\H5P\ContentType\MultiChoice\Base\AppContentMultiChoice;
use AppBundle\Entity\Media\Base\AppGallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="h5p__content__questionset")
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
class ContentQuestionSet extends AppContentQuestionSet {
	public function buildParameterObject() {
		$obj                             = new \stdClass();
		$obj->introPage                  = new \stdClass();
		$obj->introPage->showIntroPage   = true;
		$obj->introPage->startButtonText = 'Start Quiz';
		$obj->introPage->title           = $this->title;
		$obj->introPage->introduction    = '<p>Intro Text</p>';
		
		$obj->introPage->backgroundImage                     = new \stdClass();
		$obj->introPage->backgroundImage->path               = 'images/backgroundImage-5974b2e53582a.jpg';
		$obj->introPage->backgroundImage->mime               = 'image/jpeg';
		$obj->introPage->backgroundImage->copyright          = new \stdClass();
		$obj->introPage->backgroundImage->copyright->license = 'U';
		$obj->introPage->backgroundImage->width              = 960;
		$obj->introPage->backgroundImage->height             = 640;
		
		$obj->progressType   = self::PROGRESS_DOTS;
		$obj->passPercentage = 50;
		$obj->questions      = array();
		
		$obj->texts                      = new \stdClass();
		$obj->texts->prevButton          = 'Previous question';
		$obj->texts->nextButton          = 'Next question';
		$obj->texts->finishButton        = 'Finish';
		$obj->texts->textualProgress     = 'Question: @current of @total questions';
		$obj->texts->jumpToQuestion      = 'Question %d of %total';
		$obj->texts->questionLabel       = 'Question';
		$obj->texts->readSpeakerProgress = 'Question @current of @total';
		$obj->texts->unansweredText      = 'Unanswered';
		$obj->texts->answeredText        = 'Answered';
		$obj->texts->currentQuestionText = 'Current question';
		
		$obj->disableBackwardsNavigation = false;
		$obj->randomQuestions            = true;
		
		$obj->endGame                     = new \stdClass();
		$obj->endGame->showResultPage     = true;
		$obj->endGame->noResultMessage    = 'Finished';
		$obj->endGame->message            = 'Your result:';
		$obj->endGame->scoreString        = 'You got @score of @total points';
		$obj->endGame->successGreeting    = 'Congratulations!';
		$obj->endGame->successComment     = 'You did very well!';
		$obj->endGame->failGreeting       = 'You did not pass this time.';
		$obj->endGame->failComment        = 'Have another try!';
		$obj->endGame->solutionButtonText = 'Show solution';
		$obj->endGame->retryButtonText    = 'Retry';
		$obj->endGame->finishButtonText   = 'Finish';
		$obj->endGame->showAnimations     = false;
		$obj->endGame->skippable          = false;
		$obj->endGame->skipButtonText     = 'Skip video';
		
		$obj->override                            = new \stdClass();
		$obj->backgroundImage                     = new \stdClass();
		$obj->backgroundImage->path               = 'images/backgroundImage-5974b2eacbf5b.jpg';
		$obj->backgroundImage->mime               = 'image/jpeg';
		$obj->backgroundImage->copyright          = new \stdClass();
		$obj->backgroundImage->copyright->license = 'U';
		$obj->backgroundImage->width              = 960;
		$obj->backgroundImage->height             = 720;
		
		return $obj;
	}
}