<?php

namespace AppBundle\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ThanhVienAdmin extends BaseAdmin {
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
			if($this->action === 'list-thieu-nhi') {
				return '::admin/binhle/thieu-nhi/thanh-vien/list-thieu-nhi.html.twig';
			}
		}
		
		return parent::getTemplate($name);
	}
	
	
	public function configureRoutes(RouteCollection $collection) {
//		$collection->add('employeesImport', $this->getRouterIdParameter() . '/import');
		$collection->add('thieuNhi', 'thieu-nhi/list');
		
		parent::configureRoutes($collection);
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id')
			->add('name')
			->add('chiDoan');
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
			return true;
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
			$query->andWhere($expr->eq($rootAlias . '.thieuNhi', $expr->literal(true)));
		}
		if($this->action === 'chia-doi-thieu-nhi') {
			$query->andWhere($expr->eq($rootAlias . '.thieuNhi', $expr->literal(true)));
			$qb->join($rootAlias . '.phanBoHangNam', 'phanBo');
			$qb->join('phanBo.chiDoan', 'chiDoan');
			$qb->andWhere($expr->eq('chiDoan.id', $expr->literal($this->actionParams['chiDoan']->getId())));
			
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
//			->addIdentifier('christianname', null, array())
			->addIdentifier('name', null, array())
			->add('dob', null, array( 'editable' => true ))
			->add('soDienThoai', null, array())
			->add('diaChiThuongTru', null, array( 'editable' => true ))
			->add('chiDoan', 'choice', array(
				'editable' => true,
//				'class' => 'Vendor\ExampleBundle\Entity\ExampleStatus',
				'choices'  => $danhSachChiDoan,
			))
			->add('namHoc', 'text', array( 'editable' => true ));
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		
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
		
		// define group zoning
		
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('user', ModelAutocompleteType::class, array( 'property' => 'username' ))
			->add('christianname', ChoiceType::class, array(
				'label'              => 'list.label_christianname',
				'required'           => true,
				'choices'            => ThanhVien::$christianNames,
				'translation_domain' => $this->translationDomain
			))
			->add('lastname', null, array(
				'label' => 'list.label_lastname',
			))
			->add('middlename', null, array(
				'label' => 'list.label_middlename',
			))
			->add('firstname', null, array(
				'label' => 'list.label_firstname',
			))
			->add('phanDoan', ChoiceType::class, array(
				'placeholder'        => 'Chọn Phân Đoàn',
				'choices'            => ThanhVien::$danhSachPhanDoan,
				'translation_domain' => $this->translationDomain
			))
			->add('chiDoan', ChoiceType::class, array(
				'placeholder'        => 'Chọn Chi Đoàn',
				'choices'            => $danhSachChiDoan,
				'translation_domain' => $this->translationDomain
			))
			->add('namHoc', null, array( 'required' => true ))
			->add('huynhTruong', null, array())
			->add('enabled', null, array())
			->add('dob', DatePickerType::class, array(
				'format' => 'dd/MM/yyyy',
			))
			->add('soDienThoai', null, array( 'required' => false ))
			->add('soDienThoaiMe', null, array( 'required' => false ))
			->add('soDienThoaiBo', null, array( 'required' => false ))
			->add('diaChiThuongTru', null, array( 'required' => true ));
		
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
		$christianName = $object->getChristianname();
		if( ! empty($christianName)) {
			$cNames        = array_flip(ThanhVien::$christianNames);
			$christianName = $cNames[ $christianName ];
		}
		$object->setChristianname($christianName);
		$lastname   = $object->getLastname() ?: '';
		$middlename = $object->getMiddlename() ?: '';
		$firstname  = $object->getFirstname() ?: '';
		$object->setName($christianName . ' ' . $lastname . ' ' . $middlename . ' ' . $firstname);
	}
}