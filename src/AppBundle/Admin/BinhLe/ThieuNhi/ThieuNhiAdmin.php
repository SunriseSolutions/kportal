<?php

namespace AppBundle\Admin\BinhLe\ThieuNhi;

use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use Sonata\AdminBundle\Form\Type\ModelType;
use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use AppBundle\Entity\User\User;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Exception\Exception;
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

class ThieuNhiAdmin extends BinhLeThieuNhiAdmin {
	protected $baseRouteName = 'admin_app_binhle_thieunhi_thieunhi';
	
	protected $baseRoutePattern = '/app/binhle-thieunhi-thieunhi';
	
	protected $datagridValues = array(
		// display the first page (default = 1)
		'_page'       => 1,
		
		// reverse order (default = 'ASC')
		'_sort_order' => 'DESC',
		
		// name of the ordered field (default = the model's id field, if any)
		'_sort_by'    => 'updatedAt',
	);
	
	
	/**
	 * @var integer
	 */
	protected $namHoc;
	
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
			
			return '::admin/binhle/thieu-nhi/thieu-nhi/list.html.twig';
		}
		
		return parent::getTemplate($name);
	}
	
	
	public function configureRoutes(RouteCollection $collection) {
//		$collection->add('employeesImport', $this->getRouterIdParameter() . '/import');
		$collection->add('thieuNhiNhom', 'thieu-nhi/nhom-giao-ly/{phanBo}/list');
		$collection->add('thieuNhiChiDoan', 'thieu-nhi/chi-doan/{phanBo}/list');
		parent::configureRoutes($collection);
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id', null, array( 'label' => 'list.label_id' ))
			->add('name', null, array( 'label' => 'list.label_name', 'show_filter' => true ));
		if( ! in_array($this->action, [ 'list-thieu-nhi-nhom', 'list-thieu-nhi-chi-doan' ])) {
			$datagridMapper->add('chiDoan', null, array( 'label' => 'list.label_chi_doan', 'show_filter' => true ))
			               ->add('namHoc', null, array( 'label' => 'list.label_nam_hoc', 'show_filter' => true ));
		}
		$datagridMapper->add('enabled', null, array( 'label' => 'list.label_active', 'show_filter' => true ));
	}
	
	/**
	 * @param string    $name
	 * @param ThanhVien $object
	 *
	 * @return bool|mixed
	 */
	public function isGranted($name, $object = null) {
		$this->getAction();
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
		if( ! $thanhVien->isEnabled()) {
			return false;
		}
		if($name === 'xet-len-lop') {
			if(empty($object)) {
				return false;
			}
			$bangDiem = $object->getPhanBoNamNay()->createBangDiem();
			
			if(empty($bangDiem->isGradeRetention())) {
				return false;
			}
			
			if( ! $thanhVien->isHuynhTruong()) {
				return false;
			}
			if($thanhVien->isPhanDoanTruong()) {
				return true;
			}
			if($thanhVien->getChiDoan() !== $object->getChiDoan()) {
				return false;
			}
			if($thanhVien->isChiDoanTruong()) {
				return true;
			}
			$phanBo    = $thanhVien->getPhanBoNamNay();
			$cacTruong = $phanBo->getCacTruongPhuTrachDoi();
			/** @var TruongPhuTrachDoi $truong */
			foreach($cacTruong as $truong) {
				$doiNhomGiaoLy = $truong->getDoiNhomGiaoLy();
				/** @var PhanBo $_phanBoTN */
				foreach($doiNhomGiaoLy->getPhanBoHangNam() as $_phanBoTN) {
					if($_phanBoTN === $object) {
						return true;
					}
				}
			}
			
			return false;
		}
		
		if($name === 'LIST' || $name === 'VIEW') {
			return true;
		}
		
		if($name === 'CREATE') {
			return false;
		}
		
		if(in_array($this->action, [ 'truong-chi-doan', 'list-thieu-nhi-nhom' ]) || $name === 'EDIT') {
			if($this->action === 'truong-chi-doan') {
				if( ! empty($thanhVien->getPhanBoNamNay()->isChiDoanTruong())) {
					if($name === 'EDIT') {
						if(empty($object)) {
							return false;
						}
						
						return ($object->getPhanBoNamNay()->getChiDoan() === $thanhVien->getPhanBoNamNay()->getChiDoan());
					}
					
					return true;
				}
				
				return false;
			} elseif(in_array($this->action, [ 'list-thieu-nhi-nhom', 'list-thieu-nhi-chi-doan' ])) {
				if($name === 'EXPORT') {
					return true;
				}
				
				if($name === 'EDIT') {
					if($thanhVien->isChiDoanTruong()) {
						return true;
					}
					if(empty($object)) {
						return false;
					}
					
					$doiNhomGiaoLy = $object->getPhanBoNamNay()->getDoiNhomGiaoLy();
					
					if(empty($doiNhomGiaoLy)) {
						return false;
					}
					
					$cacTruongPT = $doiNhomGiaoLy->getCacTruongPhuTrachDoi();
					/** @var TruongPhuTrachDoi $item */
					foreach($cacTruongPT as $item) {
						if($item->getPhanBoHangNam()->getThanhVien()->getId() === $thanhVien->getId()) {
							return true;
						}
					}
					
					return false;
				}
				
			}
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
		
		$query->andWhere($expr->eq($rootAlias . '.huynhTruong', $expr->literal(false)));
		
		$query->andWhere($expr->eq($rootAlias . '.thieuNhi', $expr->literal(true)));
		
		/** @var ChiDoan $chiDoan */
		$chiDoan = $this->getActionParam('chiDoan');
		if($this->action === 'list-thieu-nhi-nhom') {
			/** @var array $dngl */
			$cacDoiNhomGiaoLy = $this->actionParams['cacDoiNhomGiaoLy'];
			if(count($cacDoiNhomGiaoLy) > 0) {
				$dnglIds = [];
				/** @var DoiNhomGiaoLy $dngl */
				foreach($cacDoiNhomGiaoLy as $dngl) {
					$dnglIds[] = $dngl->getId();
				}
				$qb->join($rootAlias . '.phanBoHangNam', 'phanBo');
				$qb->join('phanBo.doiNhomGiaoLy', 'doiNhomGiaoLy');
				
				$query->andWhere($expr->in('doiNhomGiaoLy.id', $dnglIds));
			} else {
				$this->clearResults($query);
			}
		} elseif($this->action === 'list-thieu-nhi-chi-doan') {
			$query->andWhere($expr->eq($rootAlias . '.chiDoan', $chiDoan->getNumber()));
			$query->andWhere($expr->eq($rootAlias . '.namHoc', $chiDoan->getNamHoc()->getId()));
		}
		
		return $query;
	}
	
	public function generateUrl($name, array $parameters = array(), $absolute = UrlGeneratorInterface::ABSOLUTE_PATH) {
		if($name === 'list') {
			if($this->action === 'list-thieu-nhi') {
				$name = 'thieuNhi';
			} elseif($this->action === 'list-thieu-nhi-nhom') {
				$name = 'thieuNhiNhom';
				if(array_key_exists('phanBo', $this->actionParams)) {
					$phanBoId = $this->actionParams['phanBo']->getId();
				} else {
					$phanBoId = $this->getRequest()->query->get('phanBoId');
				}
				$parameters['phanBo'] = $phanBoId;
			}
		} elseif($name === 'edit') {
		
		}
		
		return parent::generateUrl($name, $parameters, $absolute);
	}
	
	public function getPersistentParameters() {
		$parameters = parent::getPersistentParameters();
		if( ! $this->hasRequest() || empty($this->action)) {
			return $parameters;
		}
		if(array_key_exists('phanBo', $this->actionParams)) {
			$phanBoId = $this->actionParams['phanBo']->getId();
		} else {
			$phanBoId = $this->getRequest()->query->get('phanBoId');
		}
		
		return array_merge($parameters, array(
			'action'   => $this->action,
			'phanBoId' => $phanBoId
		));
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
			->addIdentifier('code')
//			->addIdentifier('christianname', null, array())
			->addIdentifier('name', null, array())
			->add('dob', null, array( 'editable' => true ))
			->add('soDienThoaiBo', null, array(
				'label'    => 'list.label_so_dien_thoai_bo',
				'editable' => true
			))
			->add('soDienThoaiMe', null, array(
				'label'    => 'list.label_so_dien_thoai_me',
				'editable' => true
			))
			->add('soDienThoai', null, array(
				'label'    => 'list.label_so_dien_thoai',
				'editable' => true
			))
			->add('soDienThoaiSecours', null, array(
				'label'    => 'list.label_so_dien_thoai_secours',
				'editable' => true
			))
			->add('diaChiThuongTru', null, array(
				'label'    => 'list.label_dia_chi',
				'editable' => true
			));
		
		if( ! in_array($this->action, [ 'list-thieu-nhi-chi-doan', 'list-thieu-nhi-nhom' ])) {
			$listMapper->add('chiDoan', 'choice', array(
				'editable' => false,
//				'class' => 'Vendor\ExampleBundle\Entity\ExampleStatus',
				'choices'  => $danhSachChiDoan,
			))
			           ->add('namHoc', 'text', array( 'editable' => false ));
		}
		$listMapper->add('enabled', null, array( 'editable' => true, 'label' => 'list.label_active' ))
		           ->add('_action', 'actions', array(
			           'actions' => array(
				           'edit'        => array(),
//					'delete' => array(),
				           'xet_len_lop' => array( 'template' => '::admin/binhle/thieu-nhi/thieu-nhi/list__action__xet_len_lop.html.twig' )

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
		
		$user                                    = $container->get('app.user')->getUser();
		$thanhVien                               = $user->getThanhVien();
		ThanhVienAdminHelper::$translationDomain = $this->translationDomain;
		
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
		
		
		/** @var ThanhVien $subject */
		if( ! empty($subject = $this->getSubject())) {
			$christianName = $subject->getChristianName();
			if(array_key_exists($christianName, ThanhVien::$christianNames)) {
				$christianName = ThanhVien::$christianNames[ $christianName ];
			}
		} else {
			$christianName = '';
		}
		
		// define group zoning
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general', [ 'class' => 'col-md-6' ])->end()
			->with('form.group_extra', [ 'class' => 'col-md-6' ])->end()
			//->with('form.group_job_locations', ['class' => 'col-md-4'])->end()
			->end();

//			->tab('form.tab_layout_grid')
//			->with('form.group_column', [ 'class' => 'col-md-7' ])->end()
//			->with('form.group_row', [ 'class' => 'col-md-5' ])->end()
//			->end()
//			->tab('form.tab_layout_inline')
//			->with('form.group_general', [ 'class' => 'col-md-12' ])->end()
		//->with('form.group_job_locations', ['class' => 'col-md-4'])->end()
//			->end();
		
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general');
		
		$formMapper
			->add('tenThanh', ModelType::class, array(
				'required' => false,
				'label'    => 'list.label_christianname',
				'property' => 'tiengViet'
			))
//			->add('christianname', ChoiceType::class, array(
//				'label'              => 'list.label_christianname',
//				'placeholder'        => 'Chọn Tên Thánh',
//				'required'           => false,
//				'choices'            => ThanhVien::$christianNames,
//				'data'               => $christianName,
//				'translation_domain' => $this->translationDomain
//			))
			->add('lastname', null, array(
				'label' => 'list.label_lastname',
			))
			->add('middlename', null, array(
				'label' => 'list.label_middlename',
			))
			->add('firstname', null, array(
				'label' => 'list.label_firstname',
			))
			->add('dob', DatePickerType::class, array(
				'format'   => 'dd/MM/yyyy',
				'required' => false,
				'label'    => 'list.label_dob'
			))
			->add('soDienThoai', null, array( 'required' => false, 'label' => 'list.label_so_dien_thoai', ))
			->add('soDienThoaiSecours', null, array(
				'label'    => 'list.label_so_dien_thoai_secours',
				'required' => false
			))
//			->add('soDienThoaiMe', null, array( 'required' => false,  ))
//			->add('soDienThoaiBo', null, array( 'required' => false ))
			->add('diaChiThuongTru', null, array( 'required' => false, 'label' => 'list.label_dia_chi_thuong_tru', ));
		
		$formMapper
			->end();
		
		$formMapper->with('form.group_extra')
		           ->add('phanDoan', ChoiceType::class, array(
			           'label'              => 'list.label_phan_doan',
			           'placeholder'        => 'Chọn Phân Đoàn',
			           'choices'            => ThanhVien::$danhSachPhanDoan,
			           'translation_domain' => $this->translationDomain,
			           'required'           => true
		           ))
		           ->add('chiDoan', ChoiceType::class, array(
			           'required'           => false,
			           'label'              => 'list.label_chi_doan',
			           'placeholder'        => 'Chọn Chi Đoàn',
			           'choices'            => $danhSachChiDoan,
			           'translation_domain' => $this->translationDomain
		           ))
		           ->add('enabled', null, array(
			           'label' => 'list.label_enabled',
		           ));
		$formMapper->end()->end();
		
		
	}
	
	/**
	 * @param ThanhVien $object
	 */
	public function preValidate($object) {
		$object->setThieuNhi(true);
		$object->setHuynhTruong(false);
		
		$container = $this->getConfigurationPool()->getContainer();
	}
	
	/**
	 * @param ThanhVien $object
	 */
	public function prePersist($object) {
		$container = $this->getConfigurationPool()->getContainer();
		$registry  = $container->get('doctrine');
		$userRepo  = $registry->getRepository(User::class);
		if( ! empty($userRepo->findOneBy([ 'username' => $object->getUser()->getUsername() ]))) {
			throw new Exception();
		}
//		$user = $container->get('sonata.user.user_manager')->createUser();
		$user     = $object->getUser();
		$username = $object->getUser()->getUsername();
//		$user->setUsername();
		$user->setPassword($username);
		$user->setEnabled(true);
		$user->addRole(User::ROLE_HUYNH_TRUONG);
		
		$this->getModelManager()->update($user);
	}
	
	/**
	 * @param ThanhVien $object
	 */
	public function postPersist($object) {
		$object->setCode(strtoupper(User::generate4DigitCode($object->getId())));
		$this->getModelManager()->update($object);
	}
	
	/**
	 * @return int
	 */
	public function getNamHoc() {
		return $this->namHoc;
	}
	
	/**
	 * @param int $namHoc
	 */
	public function setNamHoc($namHoc) {
		$this->namHoc = $namHoc;
	}
	
	
}