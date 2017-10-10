<?php

namespace AppBundle\Admin\Security\MenuBuilderListener;

use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\User\User;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Event\ConfigureMenuEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HuynhTruongRoleMBListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	/**
	 * @var ItemInterface
	 */
	private $menu;
	
	/**
	 * @var ItemInterface
	 */
	private $dauNam;
	
	/**
	 * @var ItemInterface
	 */
	private $banQuanTri;
	
	/**
	 * @var ItemInterface
	 */
	private $diemGiaoLy;
	
	function __construct(ContainerInterface $c) {
		$this->container = $c;
	}
	
	public function addMenuItems(ConfigureMenuEvent $event) {
		$user    = $this->container->get('app.user')->getUser();
		$request = $this->container->get('request_stack')->getCurrentRequest();
//        $pos = $user->getPosition(['roles' => [Position::ROLE_ADMIN]]);
		
		if( ! empty($thanhVien = $user->getThanhVien())) {
			if($user->hasRole(User::ROLE_HUYNH_TRUONG)) {
				$menu       = $event->getMenu();
				$this->menu = $menu;
				$translator = $this->container->get('translator');
				
				$menu->setChildren([]);
				if($thanhVien->isBQT()) {
					$this->banQuanTri = $menu->addChild('thieunhi_banquantri')->setLabel($translator->trans('dashboard.thieunhi_banquantri', [], 'BinhLeAdmin'));
					$this->addBanQuanTriMenuItems($translator, $thanhVien, []);
				}
				
				if( ! empty($thanhVien->getPhanBoNamNay()->getChiDoan())) {
					$this->dauNam     = $menu->addChild('thieunhi_daunam')->setLabel($translator->trans('dashboard.thieunhi_daunam', [], 'BinhLeAdmin'));
					$this->diemGiaoLy = $menu->addChild('thieunhi_diemgiaoly')->setLabel($translator->trans('dashboard.thieunhi_diemgiaoly', [], 'BinhLeAdmin'));
				}
				
				$this->addThanhVienMenuItems($translator, $thanhVien);
			}
		}
	}
	
	private function addBanQuanTriMenuItems($translator, ThanhVien $thanhVien, $params = array()) {
		$phanBo = $thanhVien->getPhanBoNamNay();
		$this->banQuanTri->addChild('chia doi trong chi doan', array(
			'route'           => 'admin_app_binhle_thieunhi_huynhtruong_list',
			'routeParameters' => [],
			'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
		))->setLabel($translator->trans('dashboard.binhle_thieunhi_huynhtruong', [], 'BinhLeAdmin'));
	}
	
	private function addThanhVienMenuItems($translator, ThanhVien $thanhVien, $params = array()) {
		$phanBo = $thanhVien->getPhanBoNamNay();
		
		if( ! empty($phanBo)) {
			if($phanBo->isChiDoanTruong()) {
				$this->dauNam->addChild('chia doi trong chi doan', array(
					'route'           => 'admin_app_binhle_thieunhi_chidoan_thieuNhiChiDoanChiaDoi',
					'routeParameters' => [ 'id' => $phanBo->getChiDoan()->getId() ],
					'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
				))->setLabel($translator->trans('dashboard.thieunhi_chia_doi_chi_doan', [], 'BinhLeAdmin'));
				
				
				$this->dauNam->addChild('chia doi truong chi doan', array(
					'route'           => 'admin_app_binhle_thieunhi_chidoan_thieuNhiChiDoanChiaTruongPhuTrach',
					'routeParameters' => [ 'id' => $phanBo->getChiDoan()->getId() ],
					'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
				))->setLabel($translator->trans('dashboard.thieunhi_chia_truong_chi_doan', [], 'BinhLeAdmin'));
				
				$this->diemGiaoLy->addChild('doi nhom giao ly (duyet diem)', array(
					'route'           => 'admin_app_binhle_thieunhi_doinhomgiaoly_list',
					'routeParameters' => [],
					'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
				))->setLabel($translator->trans('dashboard.thieunhi_doi_nhom_giao_ly_duyet_diem', [], 'BinhLeAdmin'));
			}
			
			if( ! empty($this->dauNam)) {
				if($phanBo->getCacTruongPhuTrachDoi()->count() > 0) {
					$this->dauNam->addChild('truong phu trach ghi nhan tien quy', array(
						'route'           => 'admin_app_binhle_thieunhi_tv_truongphutrachdoi_dongQuy',
						'routeParameters' => [ 'id' => $phanBo->getId() ],
						'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
					))->setLabel($translator->trans('dashboard.thieunhi_dong_quy', [], 'BinhLeAdmin'));
				}
			}
			
			if( ! $phanBo->isXuDoanTruong()) {
				if($phanBo->getCacTruongPhuTrachDoi()->count() > 0) {
					$this->diemGiaoLy->addChild('nhap bang diem cho nhom minh', array(
						'route'           => 'admin_app_binhle_thieunhi_phanbo_nhapDiemThieuNhi',
						'routeParameters' => [ 'id' => $phanBo->getId() ],
						'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
					))->setLabel($translator->trans('dashboard.thieunhi_nhapdiem_nhomphutrach', [], 'BinhLeAdmin'));
					
					$this->menu->addChild('thieu nhi trong nhom minh', array(
						'route'           => 'admin_app_binhle_thieunhi_thanhvien_thieuNhiNhom',
						'routeParameters' => [ 'phanBo' => $phanBo->getId() ],
						'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
					))->setLabel($translator->trans('dashboard.thieunhi_nhomphutrach', [], 'BinhLeAdmin'));
				}
				$this->menu->addChild('truong chi doan', array(
					'route'           => 'admin_app_binhle_thieunhi_thanhvien_truongChiDoan',
					'routeParameters' => [ 'chiDoan' => $phanBo->getChiDoan()->getId() ],
					'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
				))->setLabel($translator->trans('dashboard.thieunhi_truong_chi_doan', [], 'BinhLeAdmin'));
			}
			
			$this->menu->addChild('list thieu nhi toan xu doan', array(
				'route'           => 'admin_app_binhle_thieunhi_thanhvien_thieuNhi',
//			'routeParameters' => [ 'id' => $salesPartnerId ],
				'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
			))->setLabel($translator->trans('dashboard.list_thieunhi_xudoan', [], 'BinhLeAdmin'));
		}
	}
	
}