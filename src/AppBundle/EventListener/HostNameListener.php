<?php

namespace AppBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;


class HostNameListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
//        $controller = $event->getController();
//        $request = $event->getRequest();
        $host = $event->getRequest()->getHost();
        if ($this->container->hasParameter($host)) {
            $themeName = $this->container->getParameter($host);
            $activeTheme = $this->container->get('liip_theme.active_theme');
            $activeThemeName = $activeTheme->getName();
            $activeTheme->setName($themeName);
        }
        return;
    }
}