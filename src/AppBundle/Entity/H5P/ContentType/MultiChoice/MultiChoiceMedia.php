<?php

namespace AppBundle\Entity\H5P\ContentType\MultiChoice;

use AppBundle\Entity\Content\ContentNodeH5P;
use AppBundle\Entity\H5P\ContentLibrary;
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
 * @ORM\Table(name="h5p__content__multichoice_media")
 *
 */
class MultiChoiceMedia extends AppMultiChoiceMedia {
	
	
	function __construct() {
		parent::__construct();
	}
	
	public function isImage() {
		return $this->media->getProviderName() === 'sonata.media.provider.image';
	}
	
	public function isYoutube() {
		return $this->media->getProviderName() === 'sonata.media.provider.youtube';
	}
	
	public function getJsonObject() {
		$obj = new \stdClass();
		
		if( ! empty($this->media)) {
			$obj->params = new \stdClass();
			if($this->isImage()) {
				$obj->params->contentName = "Image";
				
				$obj->params->file                     = new \stdClass();
				$obj->params->file->path               = sprintf("<filePath=%s>", $this->media->getId());
				$obj->params->file->mime               = $this->media->getContentType();
				$obj->params->file->copyright          = new \stdClass();
				$obj->params->file->copyright->license = 'U';
				$obj->params->file->width              = $this->media->getWidth();
				$obj->params->file->height             = $this->media->getHeight();
				
				$obj->params->alt   = $this->media->getDescription();
				$obj->params->title = $this->media->getName();
				
				$obj->library      = $this->imageLib['machineName'] . ' ' . $this->imageLib['majorVersion'] . '.' . $this->imageLib['minorVersion'] . '.' . $this->imageLib['patchVersion'];
				$obj->subContentId = rand(1000000, 9999999);
			}
			
		}
		
		return $obj;
	}
}