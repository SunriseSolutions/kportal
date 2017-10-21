<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\ThanhVienAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\BinhLeThieuNhiAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\ThieuNhiAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\NamHoc;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use AppBundle\Entity\User\User;
use AppBundle\Service\SpreadsheetWriter;
use Ivory\CKEditorBundle\Exception\Exception;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThieuNhiAdminController extends BaseCRUDController {
	private function getRefererParams() {
		$request  = $this->getRequest();
		$referer  = $request->headers->get('referer');
		$baseUrl  = $request->getBaseUrl();
		$lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));
		
		return $this->get('router')->match($lastPath);
//		getMatcher()
	}
	
	public function sanhHoatLaiAction($id = null, Request $request) {
		/**
		 * @var ThanhVien $thanhVien
		 */
		$thanhVien = $this->admin->getSubject();
		if( ! $thanhVien) {
			throw new NotFoundHttpException(sprintf('unable to find the Thieu-nhi with id : %s', $id));
		}
		
		/** @var ThieuNhiAdmin $admin */
		$admin         = $this->admin;
		$namHocService = $this->get('app.binhle_thieunhi_namhoc');
		$phanBo        = $thanhVien->sanhHoatLai($namHocService->getNamHocHienTai());
		
		$manager = $this->get('doctrine.orm.default_entity_manager');
		$manager->persist($phanBo);
		$manager->persist($thanhVien);
		try {
			$manager->flush();
		} catch(Exception $e) {
			$this->addFlash('sonata_flash_error', $e);
		}
		
		$this->addFlash('sonata_flash_success', $thanhVien->getName() . ' đã tham gia trở lại.');
		
		$params      = $this->getRefererParams();
		$routeParams = $params;
		unset($routeParams['_route']);
		unset($routeParams['_controller']);
		unset($routeParams['_sonata_admin']);
		unset($routeParams['_sonata_name']);
		unset($routeParams['_locale']);
		
		
		return $this->redirect($this->generateUrl(
			$params['_route'],
			$routeParams
		));
	}
	
	public function thieuNhiNhomAction(PhanBo $phanBo, Request $request) {
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		
		$cacTruongPT      = $phanBo->getCacTruongPhuTrachDoi();
		$cacDoiNhomGiaoLy = [];
		
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($cacTruongPT as $truongPT) {
			$cacDoiNhomGiaoLy [] = $truongPT->getDoiNhomGiaoLy();
		}
		
		$admin->setAction('list-thieu-nhi-nhom');
		$admin->setActionParams([
			'phanBo'           => $phanBo,
			'cacDoiNhomGiaoLy' => $cacDoiNhomGiaoLy,
			'chiDoan'          => $phanBo->getChiDoan()
		]);
		
		return parent::listAction();
	}
	
	public function thieuNhiChiDoanAction(PhanBo $phanBo, Request $request) {
		
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		
		$admin->setAction('list-thieu-nhi-chi-doan');
		$admin->setActionParams([
			'phanBo'  => $phanBo,
			'chiDoan' => $phanBo->getChiDoan()
		]);
		
		return parent::listAction();
	}
	
	public function listAction() {
		/** @var ThieuNhiAdmin $admin */
		$admin = $this->admin;
		
		if( ! empty($namHoc = $this->get('app.binhle_thieunhi_namhoc')->getNamHocHienTai())) {
			$admin->setNamHoc($namHoc->getId());
		}
		
		return parent::listAction();
	}
	
}