<?php
namespace AppBundle\Service\Pagerfanta\Template;

use Pagerfanta\View\Template\TwitterBootstrap3Template;

class AppTwitterBootstrap3Template extends TwitterBootstrap3Template{
	public function __construct()
    {
        parent::__construct();
        $this->setOptions(array(
							'prev_message'        => '<i class="fa fa-angle-left"></i>',
							'next_message'        => '<i class="fa fa-angle-right"></i>'							
								)
						);
    }

    public function pageWithText($page, $text)
    {
        $class = null;

        return $this->pageWithTextAndClass($page, $text, $class);
    }

    private function pageWithTextAndClass($page, $text, $class)
    {
        $href = $this->generateRoute($page);

        return $this->linkLi($class, $href, $text,$page);
    }

    private function linkLi($class, $href, $text,$page)
    {
        $liClass = $class ? sprintf(' class="%s"', $class) : '';

        return sprintf('<li%1$s><a data-page="%4$s" href="%2$s">%3$s</a></li>', $liClass, $href, $text,$page);
    }

}