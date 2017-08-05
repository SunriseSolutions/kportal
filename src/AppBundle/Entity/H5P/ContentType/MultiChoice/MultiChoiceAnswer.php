<?php

namespace AppBundle\Entity\H5P\ContentType\MultiChoice;

use AppBundle\Entity\Content\ContentPieceH5P;
use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\ContentType\MultiChoice\Base\AppMultiChoiceAnswer;
use AppBundle\Entity\H5P\ContentType\MultiChoice\Base\AppMultiChoiceMedia;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="h5p__content__multichoice_answer")
 *
 */
class MultiChoiceAnswer extends AppMultiChoiceAnswer {
	
	function __construct() {
	}
	
	public function getJsonObject() {
		$obj                                     = new \stdClass();
		$obj->correct                            = $this->isCorrect();
		$obj->tipsAndFeedback                    = new \stdClass();
		$obj->tipsAndFeedback->tip               = $this->getTip();
		$obj->tipsAndFeedback->chosenFeedback    = $this->getFeedbackChosen();
		$obj->tipsAndFeedback->notChosenFeedback = $this->getFeedbackNotChosen();
		$obj->text                               = $this->getText();
		
		return $obj;
	}
}