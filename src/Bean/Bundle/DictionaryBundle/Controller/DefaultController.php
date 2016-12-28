<?php

namespace Bean\Bundle\DictionaryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BeanDictionaryBundle:Default:index.html.twig');
    }
}
