<?php

namespace AppBundle\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\BinhLe\ThieuNhi\NamHoc;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use Bean\Bundle\CoreBundle\Service\StringService;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\BooleanType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Valid;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class TruongPhuTrachDoiAdmin extends BaseAdmin {
	
	public function getTemplate($name) {
		if($name === 'list') {
//			return '::admin/binhle/thieu-nhi/phan-bo/list.html.twig';
		}
		
		return parent::getTemplate($name);
	}
	
	public function configureRoutes(RouteCollection $collection) {
		parent::configureRoutes($collection);
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id');
	}
	
	/**
	 * @param string $name
	 * @param NamHoc $object
	 *
	 * @return bool|mixed
	 */
	public function isGranted($name, $object = null) {
		$container = $this->getConfigurationPool()->getContainer();
		
		$tv = $this->getUserThanhVien();
		if(empty($tv) || ! $tv->isEnabled()) {
			return $this->isAdmin();
		}
		
		$user = $container->get('app.user')->getUser();
		if(empty($thanhVien = $user->getThanhVien())) {
			return false;
		} elseif($thanhVien->isBQT()) {
			return true;
		}
		
		return parent::isGranted($name, $object);
	}
	
	public function createQuery($context = 'list') {
		/** @var ProxyQuery $query */
		$query = parent::createQuery($context);
		
		return $query;
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
//			->addIdentifier('id')
			->add('id', 'text', array())
			->add('_action', 'actions', array(
				'actions' => array(
					'edit' => array(),
					'delete' => array(),
//					'send_evoucher' => array( 'template' => '::admin/employer/employee/list__action_send_evoucher.html.twig' )

//                ,
//                    'view_description' => array('template' => '::admin/product/description.html.twig')
//                ,
//                    'view_tos' => array('template' => '::admin/product/tos.html.twig')
				)
			));
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
			->add('id', null, array( 'label' => 'list.label_nam_hoc' ))
		;
		
		
		$formMapper
			->end()
			->end();
		
	}
	
	/**
	 * @param NamHoc $object
	 */
	public function preValidate($object) {
	
	}
	
	/** @param NamHoc $object */
	public function prePersist($object) {

	}
}