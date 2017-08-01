<?php

namespace AppBundle\Admin\Security\MenuBuilderListener;

use AppBundle\Entity\ChannelPartner\BusinessChannelPartner;
use AppBundle\Entity\ChannelPartner\ChannelPartner;
use AppBundle\Entity\ChannelPartner\ChannelPartnerEmployer;
use AppBundle\Entity\Employer\BusinessEmployer;
use AppBundle\Entity\SalesPartner\SalesPartner;
use AppBundle\Entity\SalesPartner\SalesPartnerBusinessChannelPartner;
use AppBundle\Entity\SalesPartner\SalesPartnerConsumerChannelPartner;
use Application\Bean\OrganisationBundle\Entity\Organisation;
use Application\Bean\OrganisationBundle\Entity\Position;
use Application\Sylius\OrderBundle\Entity\Payment;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Event\ConfigureMenuEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TeacherRoleMBListener {
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
		if( ! $user->isAdmin()) {
			$this->addTeacherMenuItems($menu, $translator);
		}
	}
	
	private function addTeacherMenuItems(ItemInterface $menu, $translator, $params = array()) {
		$menu->addChild('add csam', array(
			'route'           => 'admin_app_user_user_list',
//			'routeParameters' => [ 'id' => $salesPartnerId ],
			'labelAttributes' => array( 'icon' => 'fa fa-bar-chart' ),
		))->setLabel($translator->trans('dashboard.list_user', [], 'SonataAdminBundle'));
	}
	
}