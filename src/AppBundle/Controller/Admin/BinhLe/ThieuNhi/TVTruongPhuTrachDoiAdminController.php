<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\ChiDoanAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\PhanBoAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\TruongPhuTrachDoiAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\TVTruongPhuTrachDoiAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TVTruongPhuTrachDoiAdminController extends BaseCRUDController {
	
	public function dongQuyAction($id = null, Request $request) {
		/**
		 * @var PhanBo $phanBo
		 */
		$phanBo = $this->admin->getSubject();
		if( ! $phanBo) {
			throw new NotFoundHttpException(sprintf('unable to find the PhanBo with id : %s', $id));
		}
		
		/** @var TVTruongPhuTrachDoiAdmin $admin */
		$admin = $this->admin;
		
		
		$phanBoHangNam = $phanBo->getCacPhanBoThieuNhiPhuTrach();
		
		$admin->setAction('dong-quy');
		$admin->setActionParams([
			'chiDoan'        => $phanBo->getChiDoan(),
			'phanBoHangNam'  => $phanBoHangNam,
			'christianNames' => ThanhVien::$christianNames
		]);
		
		return parent::listAction();
	}
	
	
}