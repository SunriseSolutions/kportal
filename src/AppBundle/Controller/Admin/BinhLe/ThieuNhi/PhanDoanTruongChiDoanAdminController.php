<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\PhanDoanTruongChiDoanAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\ThanhVienAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\NamHoc;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use AppBundle\Entity\User\User;
use AppBundle\Service\SpreadsheetWriter;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhanDoanTruongChiDoanAdminController extends BaseCRUDController {
	
	public function baoCaoTienQuyAction(Request $request) {
		/** @var PhanDoanTruongChiDoanAdmin $admin */
		$admin = $this->admin;

//		if( ! empty($namHoc = $this->get('app.binhle_thieunhi_namhoc')->getNamHocHienTai())) {
//			$admin->setNamHoc($namHoc->getId());
//		}
		
		$admin->setAction('bao-cao-tien-quy');
		
		return parent::listAction();
		
	}
	
	public function bangDiemAction($id = null, $hocKy = null, $action = null, Request $request) {
		/**
		 * @var ChiDoan $chiDoan
		 */
		$chiDoan = $this->admin->getSubject();
		if( ! $chiDoan) {
			throw new NotFoundHttpException(sprintf('Unable to find the Chi Doan with id : %s', $id));
		}
		
		/** @var PhanDoanTruongChiDoanAdmin $admin */
		$admin = $this->admin;
		
		if( ! in_array($action, [ 'duyet', 'tra-ve' ])) {
			throw new InvalidArgumentException();
		}
		
		if( ! in_array(intval($hocKy), [ 1, 2 ])) {
			throw new InvalidArgumentException();
		}
		
		$manager = $this->get('doctrine.orm.entity_manager');
		
		$setterDuyetBandDiemMethod   = 'setDuocDuyetBangDiemHK' . $hocKy;
		$setterHoanTatBandDiemMethod = 'setHoanTatBangDiemHK' . $hocKy;
		
		if($action === 'duyet') {
			$chiDoan->$setterDuyetBandDiemMethod(true);
		} elseif($action === 'tra-ve') {
			$chiDoan->$setterDuyetBandDiemMethod(false);
			$chiDoan->$setterHoanTatBandDiemMethod(false);
		}
		
		try {
			$manager->persist($chiDoan);
			$manager->flush();
			if($action === 'duyet') {
				$this->addFlash('sonata_flash_success', sprintf("Bảng điểm Chi-đoàn %s đã được duyệt.", $chiDoan->getNumber()));
			} elseif($action === 'tra-ve') {
				$this->addFlash('sonata_flash_success', sprintf("Bảng điểm Chi-đoàn %s đã bị trả về.", $chiDoan->getNumber()));
			}
			
		} catch(\Exception $exception) {
			$this->addFlash('sonata_flash_error', $exception->getMessage());
		}
		
		return new RedirectResponse($this->generateUrl('admin_app_binhle_thieunhi_phandoantruong_chidoan_list', [ 'action' => 'duyet-bang-diem' ]));
	}
	
}