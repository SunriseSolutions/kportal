<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\ChiDoanAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChiDoanAdminController extends BaseCRUDController {
	
	public function thieuNhiChiDoanChiaDoiAction($id = null, Request $request) {
		
		/**
		 * @var ChiDoan $chiDoan
		 */
		$chiDoan = $this->admin->getSubject();
		if( ! $chiDoan) {
			throw new NotFoundHttpException(sprintf('unable to find the Principal with id : %s', $id));
		}
		
		/** @var ChiDoanAdmin $admin */
		$admin = $this->admin;
		
		if( ! $admin->isGranted('chia-doi-thieu-nhi', $chiDoan)) {
			throw new AccessDeniedHttpException();
		}
		$admin->setAction('chia-doi-thieu-nhi');
		$admin->setActionParams([ 'chiDoan' => $chiDoan, 'christianNames' => ThanhVien::$christianNames ]);
		
		return parent::listAction();
	}
	
	
}