<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\JobCandidate;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class BaseCRUDController extends CRUDController
{
    protected function isAdmin()
    {
        return $this->get('app.user')->getUser()->isAdmin();
    }


}