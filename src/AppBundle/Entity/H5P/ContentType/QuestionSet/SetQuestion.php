<?php

namespace AppBundle\Entity\H5P\ContentType\QuestionSet;

use AppBundle\Entity\H5P\ContentType\QuestionSet\Base\AppContentQuestionSet;

use AppBundle\Entity\H5P\Base\AppContent;
use AppBundle\Entity\H5P\ContentType\MultiChoice\Base\AppContentMultiChoice;
use AppBundle\Entity\H5P\ContentType\QuestionSet\Base\AppSetQuestion;
use AppBundle\Entity\Media\Base\AppGallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="h5p__content__questionset_question")
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
class SetQuestion extends AppSetQuestion {
	public function buildParameterObject() {
		$obj                             = new \stdClass();

		
		return $obj;
	}
}