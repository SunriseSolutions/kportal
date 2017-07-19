<?php
namespace AppBundle\Admin\Security\Handler;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Security\Handler\RoleSecurityHandler as BaseHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

class RoleSecurityHandler extends BaseHandler
{
    /**
     * @var AuthorizationChecker
     */
    protected $authorizationChecker;

    /** @var ContainerInterface $container */
    private $container;

    /**
     * NEXT_MAJOR: Go back to signature class check when bumping requirements to SF 2.6+.
     *
     * @param AuthorizationCheckerInterface|SecurityContextInterface $authorizationChecker
     * @param array $superAdminRoles
     */
    public function __construct($authorizationChecker, array $superAdminRoles, ContainerInterface $container)
    {
        parent::__construct($authorizationChecker, $superAdminRoles);
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function isGranted(AdminInterface $admin, $attributes, $object = null)
    {
        if ($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }
        $baseRole = $this->getBaseRole($admin);
//        $position = $this->container->get('app.user')->getPosition();
//        if (!empty($position)) {
//            $org = $position->getEmployer();
//            if (!is_array($attributes)) {
//                $attributes = array($attributes);
//            }
//
//            foreach ($attributes as $pos => $attribute) {
//
//                if ($position->hasRole(Position::ROLE_ADMIN)) {
//                    if ($org->isTypeSalesPartner()) {
//
//                    }
//                    if ($org->isTypeBusinessChannelPartner()) {
//                        if ($baseRole === 'ROLE_APP_ADMIN_BUSINESS_CHANNEL_PARTNER_PRODUCT_%s' && in_array($attribute, ['CREATE', 'EDIT'])) {
//                            return false;
//                        }
//                    }
//                    if ($org->isTypeConsumerChannelPartner()) {
//                        if ($baseRole === 'ROLE_APP_ADMIN_CONSUMER_CHANNEL_PARTNER_PRODUCT_%s' && in_array($attribute, ['CREATE', 'EDIT'])) {
//                            return false;
//                        }
//// Should be in OrderAdmin
////                    if ($baseRole === 'ROLE_APP_ADMIN_ORDER_%s' && in_array($attribute, ['DELETE'])) {
////                        if ($object->getSubject()->getCreatedAt() > strtotime("-24 hours")) {
////                            return true;
////                        };
////                        return false;
////                    }
//                    }
//                }
//
//
//                $attributes[$pos] = sprintf($baseRole, $attribute);
//            }
//        }

        $allRole = sprintf($baseRole, 'ALL');

        try {
            return $this->authorizationChecker->isGranted($this->superAdminRoles)
                || $this->authorizationChecker->isGranted($attributes, $object)
                || $this->authorizationChecker->isGranted(array($allRole), $object);
        } catch (AuthenticationCredentialsNotFoundException $e) {
            return false;
        }
    }
}