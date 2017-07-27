<?php

namespace AppBundle\Entity\H5P\ContentType\DragQuestion;

use AppBundle\Entity\H5P\ContentType\DragQuestion\Base\AppContentDragQuestion;

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
 * @ORM\Table(name="h5p__content__dragquestion")
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
class ContentDragQuestion extends AppContentDragQuestion {
	public function buildParameterObject() {
		$obj = new \stdClass();
		
		$obj->scoreShow        = 'Check';
		$obj->tryAgain         = 'Retry';
		$obj->correct          = 'Show solution';
		$obj->feedback         = 'You got @score of @total points';
		$obj->scoreExplanation = 'Correct answers give +1 point. Incorrect answers give -1 point. The lowest possible score is 0.';
		
		$obj->question           = new \stdClass();
		$obj->question->settings = new \stdClass();
		$obj->question->task     = new \stdClass();
		
		$obj->question->settings->questionTitle = $this->getTitle();
		$obj->question->settings->showTitle     = true;
		
		$obj->question->settings->size        = new \stdClass();
		$obj->question->settings->size->width = 620;
		$obj->question->settings->size->width = 310;
		
		$obj->question->settings->dropZoneHighlighting = 'dragging';
		$obj->question->settings->autoAlignSpacing     = 2;
		
		$obj->question->settings->background                     = new \stdClass();
		$obj->question->settings->background->path               = 'images/background-59796ad2b8f5e.jpg';
		$obj->question->settings->background->mime               = 'image/jpeg';
		$obj->question->settings->background->copyright          = new \stdClass();
		$obj->question->settings->background->copyright->license = 'U';
		$obj->question->settings->background->width              = 960;
		$obj->question->settings->background->height             = 953;
		
		return $obj;
	}
}