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
			$obj->params       = new \stdClass();
			$obj->subContentId = rand(1000000, 9999999);
			
			if($this->isImage()) {
				$obj->params->contentName = "Image";
				
				$obj->params->file                     = new \stdClass();
				$obj->params->file->path               = sprintf("<filePath=%s>", $this->media->getId() . '.' . $this->media->getExtension());
				$obj->params->file->mime               = $this->media->getContentType();
				$obj->params->file->copyright          = new \stdClass();
				$obj->params->file->copyright->license = 'U';
				$obj->params->file->width              = $this->media->getWidth();
				$obj->params->file->height             = $this->media->getHeight();
				
				$obj->params->alt   = $this->media->getDescription();
				$obj->params->title = $this->media->getName();
				
				$obj->library = $this->imageLib['machineName'] . ' ' . $this->imageLib['majorVersion'] . '.' . $this->imageLib['minorVersion'] . '.' . $this->imageLib['patchVersion'];
			} elseif($this->isYoutube()) {
				$obj->params->visuals           = new \stdClass();
				$obj->params->visuals->fit      = false;
				$obj->params->visuals->controls = true;
				
//				$obj->params->visuals->poster            = new \stdClass();
//				$obj->params->visuals->poster->path      = 'http://test.local.com/001/wordpress/wp-content/uploads/h5p/content/4/images/poster-597763ca40cbc.png';
//				$obj->params->visuals->poster->mime      = 'image/png';
//				$obj->params->visuals->poster->copyright = new \stdClass();
//				$obj->params->visuals->poster->width     = 683;
//				$obj->params->visuals->poster->height    = 331;
				
				$obj->params->playback           = new \stdClass();
				$obj->params->playback->autoplay = false;
				$obj->params->playback->loop     = false;
				
				$obj->params->l10n                     = new \stdClass();
				$obj->params->l10n->name               = 'Video';
				$obj->params->l10n->loading            = 'Video player loading...';
				$obj->params->l10n->noPlayers          = 'Found no video players that supports the given video format.';
				$obj->params->l10n->noSources          = 'Video is missing sources.';
				$obj->params->l10n->aborted            = 'Media playback has been aborted.';
				$obj->params->l10n->networkFailure     = 'Network failure.';
				$obj->params->l10n->cannotDecode       = 'Unable to decode media.';
				$obj->params->l10n->formatNotSupported = 'Video format not supported.';
				$obj->params->l10n->mediaEncrypted     = 'Media encrypted.';
				$obj->params->l10n->unknownError       = 'Unknown error.';
				$obj->params->l10n->invalidYtId        = 'Invalid YouTube ID.';
				$obj->params->l10n->unknownYtId        = 'Unable to find video with the given YouTube ID.';
				$obj->params->l10n->restrictedYt       = 'The owner of this video does not allow it to be embedded.';
				
				$obj->params->sources       = [];
				$source                     = new \stdClass();
				$source->path               = sprintf('https://www.youtube.com/watch?v=%s', $this->media->getProviderReference());
				$source->mime               = 'video/YouTube';
				$source->copyright          = new \stdClass();
				$source->copyright->license = 'U';
				$obj->params->sources[]     = $source;
				
				$obj->params->a11y = [];
				$obj->library      = $this->vidLib['machineName'] . ' ' . $this->vidLib['majorVersion'] . '.' . $this->vidLib['minorVersion'] . '.' . $this->vidLib['patchVersion'];
			}
			
		}
		
		return $obj;
	}
}