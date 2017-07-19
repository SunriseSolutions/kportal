<?php

namespace AppBundle\Controller\Media;

use Sonata\MediaBundle\Controller\MediaController as BaseMediaController;

use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MediaController extends BaseMediaController {
	public function getRequest() {
		return $this->container->get('request_stack')->getCurrentRequest();
	}
}
