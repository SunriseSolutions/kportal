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
		$manager = $this->get('doctrine.orm.default_entity_manager');
		
		if($request->isMethod('post')) {
			$diem    = floatval($request->request->get('diem', 0));
			$soTien  = $request->request->getInt('soTien', 0);
			$dongQuy = $request->request->getBoolean('dongQuy', false);
			
			$phanBoId = $request->request->get('phanBoId');
			$phanBo   = $this->getDoctrine()->getRepository(PhanBo::class)->find($phanBoId);
			
			if( ! ($dongQuy === false || $soTien <= 0 || empty($phanBo))) {
				
				
				$phanBo->setTienQuyDong($soTien);
				$phanBo->setDaDongQuy($dongQuy);
				
				$manager->persist($phanBo);
				$manager->flush();

//
				return new JsonResponse([ 'OK' ], 200);
			} else {
				return new JsonResponse([ 404, 'Không thể tìm thấy Thiếu-nhi này' ], 404);
			}
		}
		
		$phanBoHangNam = $phanBo->getCacPhanBoThieuNhiPhuTrach();
		$manager->persist($phanBo);
		$manager->flush();
		
		
		$phanBoHangNam = $phanBo->getCacPhanBoThieuNhiPhuTrach();
		
		$admin->namHoc = $phanBo->getNamHoc();
		$admin->setAction('dong-quy');
		$admin->setActionParams([
			'chiDoan'        => $phanBo->getChiDoan(),
			'phanBoHangNam'  => $phanBoHangNam,
			'christianNames' => ThanhVien::$christianNames
		]);
		
		return parent::listAction();
	}
	
	
}