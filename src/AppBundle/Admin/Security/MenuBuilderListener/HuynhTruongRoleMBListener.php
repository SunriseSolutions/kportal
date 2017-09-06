<?php

namespace AppBundle\Admin\Security\MenuBuilderListener;

use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\ChannelPartner\BusinessChannelPartner;
use AppBundle\Entity\ChannelPartner\ChannelPartner;
use AppBundle\Entity\ChannelPartner\ChannelPartnerEmployer;
use AppBundle\Entity\Employer\BusinessEmployer;
use AppBundle\Entity\SalesPartner\SalesPartner;
use AppBundle\Entity\SalesPartner\SalesPartnerBusinessChannelPartner;
use AppBundle\Entity\SalesPartner\SalesPartnerConsumerChannelPartner;
use AppBundle\Entity\User\User;
use Application\Bean\OrganisationBundle\Entity\Organisation;
use Application\Bean\OrganisationBundle\Entity\Position;
use Application\Sylius\OrderBundle\Entity\Payment;
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
	private $diemGiaoLy;
	
	function __construct(ContainerInterface $c) {
		$this->container = $c;
	}
	
	public function addMenuItems(ConfigureMenuEvent $event) {
		$user       = $this->container->get('app.user')->getUser();
		$request    = $this->container->get('request_stack')->getCurrentRequest();
//        $pos = $user->getPosition(['roles' => [Position::ROLE_ADMIN]]);
		
		if( ! empty($thanhVien = $user->getThanhVien())) {
			if($user->hasRole(User::ROLE_HUYNH_TRUONG)) {
				$menu       = $event->getMenu();
				$this->menu = $menu;
				$translator = $this->container->get('translator');
				
				$menu->setChildren([]);
				$this->dauNam = $menu->addChild('thieunhi_daunam')->setLabel($translator->trans('dashboard.thieunhi_daunam', [], 'BinhLeAdmin'));
				$this->diemGiaoLy = $menu->addChild('thieunhi_diemgiaoly')->setLabel($translator->trans('dashboard.thieunhi_diemgiaoly', [], 'BinhLeAdmin'));
				
				$this->addThanhVienMenuItems($translator, $thanhVien);
			}
		}
	}
	
	private function addThanhVienMenuItems($translator, ThanhVien $thanhVien, $params = array()) {
		$phanBo = $thanhVien->getPhanBoNamNay();
		
		$this->menu->addChild('list thieu nhi toan xu doan', array(
			'route'           => 'admin_app_binhle_thieunhi_thanhvien_thieuNhi',
//			'routeParameters' => [ 'id' => $salesPartnerId ],
			'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
		))->setLabel($translator->trans('dashboard.list_thieunhi_xudoan', [], 'BinhLeAdmin'));
		
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
				
				
				$this->menu->addChild('truong chi doan', array(
					'route'           => 'admin_app_binhle_thieunhi_thanhvien_truongChiDoan',
					'routeParameters' => [ 'chiDoan' => $phanBo->getChiDoan()->getId() ],
					'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
				))->setLabel($translator->trans('dashboard.thieunhi_truong_chi_doan', [], 'BinhLeAdmin'));
			}
			
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
	}
	
}