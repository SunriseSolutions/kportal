<?php
namespace AppBundle\Admin\User;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserAdmin extends BaseUserAdmin
{    private $action;

    protected $datagridValues = array(
        // display the first page (default = 1)
//        '_page' => 1,
        // reverse order (default = 'ASC')
        '_sort_order' => 'DESC',
        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'updatedAt',
    );

    /**
     * @param string $name
     * @param User $object
     */
    public function isGranted($name, $object = null)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $isAdmin = $container->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
//        $pos = $container->get('app.user')->getPosition();
        if (in_array($name, ['CREATE', 'DELETE', 'LIST'])) {
            return $isAdmin;
        }
        if ($name === 'EDIT') {
            if ($isAdmin) {
                return true;
            }
            if (!empty($object) && $object->getId() === $container->get('app.user')->getUser()->getId()) {
                return true;
            }
            return false;
        }
//        if (empty($isAdmin)) {
//            return false;
//        }

        return parent::isGranted($name, $object);
    }

    public function toString($object)
    {
        return $object instanceof User
            ? $object->getEmail()
            : 'Talent'; // shown in the breadcrumb on the create view
    }

    public function createQuery($context = 'list')
    {
        /** @var ProxyQueryInterface $query */
        $query = parent::createQuery($context);
        if (empty($this->getParentFieldDescription())) {
//            $this->filterQueryByPosition($query, 'position', '', '');
        }

//        $query->andWhere()

        return $query;
    }

    public function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('talent_bank', 'talent-bank');
        $collection->add('show_user_profile', $this->getRouterIdParameter() . '/show-user-profile');

    }

    public function getTemplate($name)
    {
        return parent::getTemplate($name);
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        parent::configureShowFields($showMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper->remove('impersonating');
        $listMapper->remove('groups');
        $listMapper->add('positions', null, ['template'=>'::admin/user/list__field_positions.html.twig']);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getConfigurationPool()->getContainer()->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            parent::configureFormFields($formMapper);
        } else {
//        $formMapper->removeGroup('Social','User');
//        $formMapper->removeGroup('Groups','Security');
//        $formMapper->removeGroup('Keys','Security');
//        $formMapper->removeGroup('Status','Security');
//        $formMapper->removeGroup('Roles','Security');
//        $formMapper->remove('Security');
//
//        $formMapper->remove('dateOfBirth');
//        $formMapper->remove('website');
//        $formMapper->remove('biography');
//        $formMapper->remove('gender');
//        $formMapper->remove('locale');
//        $formMapper->remove('timezone');
//        $formMapper->remove('phone');
            $formMapper
                ->with('Profile', ['class' => 'col-md-6'])->end()
                ->with('General', ['class' => 'col-md-6'])->end();

            $formMapper
                ->with('General')
//                ->add('username')
                ->add('email')
//                ->add('admin')
                ->add('plainPassword', 'text', [
                    'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
                ])
                ->end()
                ->with('Profile')
	            ->add('lastname', null, ['required' => false])
	            ->add('middlename', null, ['required' => false])
                ->add('firstname', null, ['required' => false])
                ->end();
        }

    }

    /**
     * @param User $object
     */
    public function prePersist($object)
    {
        parent::prePersist($object);
        if (!$object->isEnabled()) {
            $object->setEnabled(true);
        }
    }

    /**
     * @param User $object
     */
    public function preUpdate($object)
    {
        parent::preUpdate($object);
        if (!$object->isEnabled()) {
            $object->setEnabled(true);
        }
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

}