<?php

namespace AppBundle\Entity\H5P\ContentType\MultiChoice;

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
	
	/**
	 * @var ArrayCollection
	 * One Customer has One Cart.
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceAnswer", mappedBy="question", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $answers;
	
	/**
	 * @var MultiChoiceMedia
	 * One Customer has One Cart.
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceMedia", mappedBy="question", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $multichoiceMedia;
	
	public function buildParameterObject() {
		$obj = new \stdClass();
		if( ! empty($this->multichoiceMedia)) {
			$obj->media = $this->multichoiceMedia->getJsonObject();
		} else {
			$obj->media = new \stdClass();
		}
		
		$obj->answers = [];
		/** @var MultiChoiceAnswer $answer */
		foreach($this->answers as $answer) {
			$obj->answers[] = $answer->getJsonObject();
		}
		
		return $obj;
	}
	
	/**
	 * @param MultiChoiceMedia $multichoiceMedia
	 */
	public function setMultichoiceMedia($multichoiceMedia) {
		$this->multichoiceMedia = $multichoiceMedia;
		if( ! empty($multichoiceMedia)) {
			$multichoiceMedia->setQuestion($this);
			if($multichoiceMedia->isImage()) {
				array_unshift($this->libraries, $multichoiceMedia->getImageLib());
			}
			
			if($multichoiceMedia->isYoutube()) {
				array_unshift($this->libraries, $multichoiceMedia->getFlowplayerLib(), $multichoiceMedia->getVidLib());
			}
		}
	}
	
}
