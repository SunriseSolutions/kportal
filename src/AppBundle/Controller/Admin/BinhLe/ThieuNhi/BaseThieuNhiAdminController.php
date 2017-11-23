<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Controller\Admin\BaseCRUDController;

class BaseThieuNhiAdminController extends BaseCRUDController {
	protected function getRefererParams() {
		$request  = $this->getRequest();
		$referer  = $request->headers->get('referer');
		$baseUrl  = $request->getBaseUrl();
		$lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));
		
		return $this->get('router')->match($lastPath);
//		getMatcher()
	}
	
	
}