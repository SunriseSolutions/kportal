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
		$obj->question->settings->size->height = 613.5;
		
		$obj->question->settings->dropZoneHighlighting = 'dragging';
		$obj->question->settings->autoAlignSpacing     = 2;
		
		$obj->question->settings->background                     = new \stdClass();
		$obj->question->settings->background->path               = 'images/background-59796ad2b8f5e.jpg';
		$obj->question->settings->background->mime               = 'image/jpeg';
		$obj->question->settings->background->copyright          = new \stdClass();
		$obj->question->settings->background->copyright->license = 'U';
		$obj->question->settings->background->width              = 960;
		$obj->question->settings->background->height             = 953;
		
		$obj->question->task->elements  = array();
		$obj->question->task->dropZones = array();
		
		$element1                        = new \stdClass();
		$element1->x                     = 0;
		$element1->y                     = 70.3225806451613;
		$element1->width                 = 5;
		$element1->height                = 5;
		$element1->dropZones             = array( 0, 1, 2 );
		$element1->type                  = new \stdClass();
		$element1->type->library         = 'H5P.AdvancedText 1.1';
		$element1->type->params          = new \stdClass();
		$element1->type->params->text    = '<p>Text 1 for zone 1</p>';
		$element1->type->subContentId    = 'random-id-1';
		$element1->backgroundOpacity     = 100;
		$element1->multiple              = true;
		$obj->question->task->elements[] = $element1;
		
		$element2                                         = new \stdClass();
		$element2->x                                      = 17.741935483870968;
		$element2->y                                      = 70.3225806451613;
		$element2->width                                  = 5;
		$element2->height                                 = 5;
		$element2->dropZones                              = array( 0, 1, 2 );
		$element2->type                                   = new \stdClass();
		$element2->type->library                          = 'H5P.Image 1.0';
		$element2->type->params                           = new \stdClass();
		$element2->type->params->contentName              = 'Image';
		$element2->type->params->file                     = new \stdClass();
		$element2->type->params->file->path               = 'images/file-59796cca4c158.jpg';
		$element2->type->params->file->mime               = 'image/jpeg';
		$element2->type->params->file->copyright          = new \stdClass();
		$element2->type->params->file->copyright->license = 'U';
		$element2->type->params->file->width              = 800;
		$element2->type->params->file->height             = 800;
		$element2->type->params->alt                      = 'Gai dep';
		$element2->type->subContentId                     = 'random-id-2';
		$element2->backgroundOpacity                      = 100;
		$element2->multiple                               = false;
		$obj->question->task->elements[]                  = $element2;
		
		$dropzone1                        = new \stdClass();
		$dropzone1->x                     = 4.838709677419355;
		$dropzone1->y                     = 22.58064516129032;
		$dropzone1->width                 = 10;
		$dropzone1->height                = 6.25;
		$dropzone1->correctElements       = array( 0 );
		$dropzone1->showLabel             = true;
		$dropzone1->backgroundOpacity     = 0;
		$dropzone1->single                = true;
		$dropzone1->autoAlign             = true;
		$dropzone1->label                 = '<div>Zone 1 - label shown</div>';
		$dropzone1->tip                   = '<p>Tip text here</p>';
		$obj->question->task->dropZones[] = $dropzone1;
		
		$dropzone2                        = new \stdClass();
		$dropzone2->x                     = 35.483870967741936;
		$dropzone2->y                     = 16.129032258064516;
		$dropzone2->width                 = 8.75;
		$dropzone2->height                = 6.25;
		$dropzone2->correctElements       = array( 0 );
		$dropzone2->showLabel             = false;
		$dropzone2->backgroundOpacity     = 20;
		$dropzone2->single                = true;
		$dropzone2->autoAlign             = true;
		$dropzone2->label                 = '<div>Zone 2 - label hidden</div>';
		$dropzone2->tip                   = '<p>Tip 222222222222</p>';
		$obj->question->task->dropZones[] = $dropzone2;
		
		$dropzone3                        = new \stdClass();
		$dropzone3->x                     = 77.41935483871;
		$dropzone3->y                     = 22.58064516129032;
		$dropzone3->width                 = 8.75;
		$dropzone3->height                = 6.875;
		$dropzone3->correctElements       = array( 1 );
		$dropzone3->showLabel             = false;
		$dropzone3->backgroundOpacity     = 0;
		$dropzone3->single                = false;
		$dropzone3->autoAlign             = false;
		$dropzone3->label                 = '<div>Zone 3 - special properties</div>';
		$dropzone3->tip                   = '<p>Tip 33333333333</p>';
		$obj->question->task->dropZones[] = $dropzone3;
		
		$obj->behaviour                             = new \stdClass();
		$obj->behaviour->enableRetry                = true;
		$obj->behaviour->showSolutionsRequiresInput = true;
		$obj->behaviour->singlePoint                = true;
		$obj->behaviour->applyPenalties             = true;
		$obj->behaviour->enableScoreExplanation     = true;
		
		$obj->backgroundOpacity = '0';
		
		return $obj;
	}
}