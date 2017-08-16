<?php

namespace AppBundle\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Valid;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class ChiDoanAdmin extends BaseAdmin {
	
	protected $action = '';
	protected $actionParams = [];
	
	/**
	 * @return array
	 */
	public function getActionParams() {
		return $this->actionParams;
	}
	
	/**
	 * @param array $actionParams
	 */
	public function setActionParams($actionParams) {
		$this->actionParams = $actionParams;
	}
	
	public function setAction($action) {
		$this->action = $action;
	}
	
	public function getTemplate($name) {
		if($name === 'list') {
			if($this->action === 'chia-doi-thieu-nhi') {
				return '::admin/binhle/thieu-nhi/chi-doan/list-chia-doi-thieu-nhi.html.twig';
			}
			
			return '::admin/binhle/thieu-nhi/chi-doan/list.html.twig';
		}
		
		return parent::getTemplate($name);
	}
	
	
	public function configureRoutes(RouteCollection $collection) {
		$collection->add('thieuNhiChiDoanChiaDoi', $this->getRouterIdParameter() . '/thieu-nhi/chia-doi');
		
		parent::configureRoutes($collection);
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		$action       = $this->action;
		$actionParams = $this->actionParams;
		
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id');
	}
	
	/**
	 * @param string    $name
	 * @param ThanhVien $object
	 *
	 * @return bool|mixed
	 */
	public function isGranted($name, $object = null) {
		$container = $this->getConfigurationPool()->getContainer();
		
		if($this->isAdmin()) {
			return true;
		}
		
		if($name === 'DELETE') {
			return false;
		}
		
		$user = $container->get('app.user')->getUser();
		if(empty($thanhVien = $user->getThanhVien())) {
			return false;
		} elseif($thanhVien->isBQT()) {
			if($name === 'chia-doi-thieu-nhi') {
				return false;
			}
			
			return true;
		}
		
		if($name === 'chia-doi-thieu-nhi') {
			if(empty($phanBoNamNay = $thanhVien->getPhanBoNamNay())) {
				return false;
			}
			if(empty($phanBoNamNay->getNamHoc()->isEnabled())) {
				return false;
			}
			if($phanBoNamNay->isChiDoanTruong()) {
				if($phanBoNamNay->getChiDoan()->getId() === $object->getId()) {
					return true;
				}
			}
			
			return false;
		}
		
		if($name === 'LIST') {
			return true;
		}
		
		return false;


//		return parent::isGranted($name, $object);
	}
	
	public function createQuery($context = 'list') {
		/** @var ProxyQuery $query */
		$query = parent::createQuery($context);
		/** @var QueryBuilder $qb */
		$qb        = $query->getQueryBuilder();
		$expr      = $qb->expr();
		$rootAlias = $qb->getRootAliases()[0];
		if($this->action === 'list-thieu-nhi') {
			$this->clearResults($query);
		}
		if($this->action === 'chia-doi-thieu-nhi') {
			$this->clearResults($query);
		}
		
		return $query;
	}
	
	public function generateUrl($name, array $parameters = array(), $absolute = UrlGeneratorInterface::ABSOLUTE_PATH) {
		if($this->action === 'list-thieu-nhi') {
			if($name === 'list') {
				$name = 'thieuNhi';
			}
		}
		
		return parent::generateUrl($name, $parameters, $absolute);
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$danhSachChiDoan = [
			'Chiên Con 4 tuổi'    => 4,
			'Chiên Con 5 tuổi'    => 5,
			'Chiên Con 6 tuổi'    => 6,
			'Ấu Nhi 7 tuổi'       => 7,
			'Ấu Nhi 8 tuổi'       => 8,
			'Ấu Nhi 9 tuổi'       => 9,
			'Thiếu Nhi 10 tuổi'   => 10,
			'Thiếu Nhi 11 tuổi'   => 11,
			'Thiếu Nhi 12 tuổi'   => 12,
			'Nghĩa Sĩ 13 tuổi'    => 13,
			'Nghĩa Sĩ 14 tuổi'    => 14,
			'Nghĩa Sĩ 15 tuổi'    => 15,
			'Tông Đồ 16 tuổi'     => 16,
			'Tông Đồ 17 tuổi'     => 17,
			'Tông Đồ 18 tuổi'     => 18,
			'Dự Trưởng (19 tuổi)' => 19,
		];
		
		$listMapper
//			->addIdentifier('id')
			->addIdentifier('id', null, array())
//			->add('thanhVien', null, array( 'associated_property' => 'name' ))
			->add('thanhVien.christianName', null, array(
				'label' => 'list.label_christianname'
			))
			->add('thanhVien.lastName', null, array(
				'label' => 'list.label_lastname'
			))
			->add('thanhVien.middleName', null, array(
				'label' => 'list.label_middlename'
			))
			->add('thanhVien.firstName', null, array(
				'label' => 'list.label_firstname'
			));
		if($this->action === 'chia-doi-thieu-nhi') {
			$listMapper->add('phanBoTruoc.bangDiem', null, array( 'associated_property' => 'tbYear' ));
		}
		$listMapper->add('chiDoan', null, array(
			'associated_property' => 'number'
		));
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
		
		$danhSachChiDoan = [
			'Chiên Con 4 tuổi'    => 4,
			'Chiên Con 5 tuổi'    => 5,
			'Chiên Con 6 tuổi'    => 6,
			'Ấu Nhi 7 tuổi'       => 7,
			'Ấu Nhi 8 tuổi'       => 8,
			'Ấu Nhi 9 tuổi'       => 9,
			'Thiếu Nhi 10 tuổi'   => 10,
			'Thiếu Nhi 11 tuổi'   => 11,
			'Thiếu Nhi 12 tuổi'   => 12,
			'Nghĩa Sĩ 13 tuổi'    => 13,
			'Nghĩa Sĩ 14 tuổi'    => 14,
			'Nghĩa Sĩ 15 tuổi'    => 15,
			'Tông Đồ 16 tuổi'     => 16,
			'Tông Đồ 17 tuổi'     => 17,
			'Tông Đồ 18 tuổi'     => 18,
			'Dự Trưởng (19 tuổi)' => 19,
		];
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('thanhVien', ModelAutocompleteType::class, array(
				'property'           => 'name',
				'to_string_callback' => function(ThanhVien $entity, $property) {
					return $entity->getName();
				},
			
			))
			->add('chiDoan', ModelAutocompleteType::class, array(
				'property' => 'id'
			));
		
		$formMapper
			->end()
			->end();
		
	}
	
	/**
	 * @param ThanhVien $object
	 */
	public function preValidate($object) {
		if( ! empty($object->isHuynhTruong())) {
			$object->setThieuNhi(false);
		}
	}
}