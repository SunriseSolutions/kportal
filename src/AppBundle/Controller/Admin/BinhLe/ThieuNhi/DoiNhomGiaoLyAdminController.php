<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\ChiDoanAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\DoiNhomGiaoLyAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class DoiNhomGiaoLyAdminController extends BaseCRUDController {
	
	public function bangDiemAction($id = null, $hocKy = null, $action = null, Request $request) {
		/**
		 * @var DoiNhomGiaoLy $dngl
		 */
		$dngl = $this->admin->getSubject();
		if( ! $dngl) {
			throw new NotFoundHttpException(sprintf('Unable to find the DoiNhomGiaoLy with id : %s', $id));
		}
		
		/** @var DoiNhomGiaoLyAdmin $admin */
		$admin = $this->admin;
		
		if( ! in_array($action, [ 'duyet', 'tra-ve' ])) {
			throw new InvalidArgumentException();
		}
		
		if( ! in_array(intval($hocKy), [ 1, 2 ])) {
			throw new InvalidArgumentException();
		}
		
		$manager = $this->get('doctrine.orm.entity_manager');
		
		$setterDuyetBandDiemMethod   = 'setDuyetBangDiemHK' . $hocKy . 'CDT';
		$setterHoanTatBandDiemMethod = 'setHoanTatBangDiemHK' . $hocKy;
		if($action === 'duyet') {
			$dngl->$setterDuyetBandDiemMethod(true);
		} elseif($action === 'tra-ve') {
			$dngl->$setterDuyetBandDiemMethod(false);
			$dngl->$setterHoanTatBandDiemMethod(false);
		}
		
		try {
			$manager->persist($dngl);
			$manager->flush();
			$this->addFlash('sonata_flash_success', sprintf("Đội %s đã được duyệt.", $dngl->getNumber()));
			
		} catch(\Exception $exception) {
			$this->addFlash('sonata_flash_error', $exception->getMessage());
		}
		
		return new RedirectResponse($this->generateUrl('admin_app_binhle_thieunhi_doinhomgiaoly_list', []));
	}
}