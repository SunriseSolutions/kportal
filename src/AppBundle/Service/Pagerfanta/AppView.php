<?php
namespace AppBundle\Service\Pagerfanta;

use AppBundle\Service\Pagerfanta\Template\AppTwitterBootstrap3Template;
use Pagerfanta\View\DefaultView;

class AppView extends DefaultView{
	
	protected function createDefaultTemplate()
    {
		return new AppTwitterBootstrap3Template(); //   return new DefaultTemplate();
    }	
	
}