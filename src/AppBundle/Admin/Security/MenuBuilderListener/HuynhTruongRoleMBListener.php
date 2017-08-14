<?php

namespace AppBundle\Admin\Security\MenuBuilderListener;

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
	
	function __construct(ContainerInterface $c) {
		$this->container = $c;
	}
	
	public function addMenuItems(ConfigureMenuEvent $event) {
		$menu       = $event->getMenu();
		$user       = $this->container->get('app.user')->getUser();
		$translator = $this->container->get('translator');
		$request    = $this->container->get('request_stack')->getCurrentRequest();
//        $pos = $user->getPosition(['roles' => [Position::ROLE_ADMIN]]);
		if($user->hasRole(User::ROLE_HUYNH_TRUONG)) {
			$menu->setChildren([]);
			$this->addThanhVienMenuItems($menu, $translator);
		}
	}
	
	private function addThanhVienMenuItems(ItemInterface $menu, $translator, $params = array()) {
		$menu->addChild('list thieu nhi toan xu doan', array(
			'route'           => 'admin_app_binhle_thieunhi_thanhvien_thieuNhi',
//			'routeParameters' => [ 'id' => $salesPartnerId ],
			'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
		))->setLabel($translator->trans('dashboard.list_thieunhi_xudoan', [], 'BinhLeAdmin'));
		
		$menu->addChild('chia doi trong chi doan', array(
			'route'           => 'admin_app_binhle_thieunhi_thanhvien_thieuNhiChiDoanChiaDoi',
			'routeParameters' => [ 'chiDoan' => '7-2017' ],
			'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
		))->setLabel($translator->trans('dashboard.thieunhi_chia_doi_chi_doan', [], 'BinhLeAdmin'));
		
		
	}
	
}