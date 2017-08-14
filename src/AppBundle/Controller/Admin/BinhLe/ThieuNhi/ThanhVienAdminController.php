<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\ThanhVienAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThanhVienAdminController extends BaseCRUDController {
	public function thieuNhiChiDoanChiaDoiAction(ChiDoan $chiDoan, Request $request) {
		
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		$admin->setAction('chia-doi-thieu-nhi');
		$admin->setActionParams([ 'chiDoan' => $chiDoan ]);
		
		return parent::listAction();
	}
	
	public function thieuNhiAction(Request $request) {
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		$admin->setAction('list-thieu-nhi');
		
		return parent::listAction();
	}
	
}