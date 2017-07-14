<?php

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SiteService extends BaseService {
	
	private $hostParams;
	
	public function getLocale() {
		if( ! empty($hostParams = $this->getHostParams())) {
			if(array_key_exists('locale', $hostParams)) {
				return $hostParams['locale'];
			}
		}
		
		return $this->container->getParameter('locale');
	}
	
	public function getHostName() {
		return $this->container->get('request_stack')->getCurrentRequest()->getHost();
	}
	
	public function getHostParams() {
		if($this->hostParams === null) {
			$host = $this->container->get('request_stack')->getCurrentRequest()->getHost();
			if($this->container->hasParameter($host)) {
				$this->hostParams = $this->container->getParameter($host);
			} else {
				$this->hostParams = [];
			}
		}
		
		return $this->hostParams;
	}
	
	public function getHostCountry() {
		if( ! empty($hostParams = $this->getHostParams())) {
			if(array_key_exists('country', $hostParams)) {
				return $hostParams['country'];
			}
		}
		
		return null;
	}
}