<?php

namespace AppBundle\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use AppBundle\Entity\User\User;
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
	 * @var integer
	 */
	protected $namHoc;
	
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
			if($this->action === 'list-thieu-nhi-nhom') {
				return '::admin/binhle/thieu-nhi/thanh-vien/list-thieu-nhi-nhom.html.twig';
			}
			
			return '::admin/binhle/thieu-nhi/thanh-vien/list.html.twig';
		}
		
		return parent::getTemplate($name);
	}
	
	
	public function configureRoutes(RouteCollection $collection) {
//		$collection->add('employeesImport', $this->getRouterIdParameter() . '/import');
		$collection->add('import', 'import/{namHoc}');
		$collection->add('thieuNhi', 'thieu-nhi/list');
		$collection->add('thieuNhiNhom', 'thieu-nhi/nhom-giao-ly/{phanBo}/list');
		$collection->add('truongChiDoan', 'truong/chi-doan-{chiDoan}/list');
		
		parent::configureRoutes($collection);
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id', null, array( 'label' => 'list.label_id' ))
			->add('name', null, array( 'label' => 'list.label_name', 'show_filter' => true ))
			->add('chiDoan', null, array( 'label' => 'list.label_chi_doan', 'show_filter' => true ))
			->add('namHoc', null, array( 'label' => 'list.label_nam_hoc', 'show_filter' => true ))
			->add('enabled', null, array( 'label' => 'list.label_active', 'show_filter' => true ));
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
		
		if(is_array($name)) {
			$name = $name[0];
		}
		
		if($name === 'DELETE') {
			return false;
		}
		
		$user = $container->get('app.user')->getUser();
		if(empty($thanhVien = $user->getThanhVien())) {
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
			} elseif($this->action === 'list-thieu-nhi-nhom') {
				if($name === 'EXPORT') {
					return true;
				}
				
				if($name === 'EDIT') {
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
		
		if(in_array($this->action, [ 'list-thieu-nhi', 'list-thieu-nhi-nhom' ])) {
			$query->andWhere($expr->eq($rootAlias . '.thieuNhi', $expr->literal(true)));
		}
		
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
		} elseif($this->action === 'thieu-nhi-chua-dong-quy') {
			// chiDoan
			
			
		} elseif($this->action === 'truong-chi-doan') {
			$query->andWhere($expr->eq($rootAlias . '.huynhTruong', $expr->literal(true)));
			$qb->join($rootAlias . '.phanBoHangNam', 'phanBo');
			$qb->join('phanBo.chiDoan', 'chiDoan');
			$qb->andWhere($expr->eq('chiDoan.id', $expr->literal($this->actionParams['chiDoan']->getId())));
			
		}
		
		return $query;
	}
	
	public function generateUrl($name, array $parameters = array(), $absolute = UrlGeneratorInterface::ABSOLUTE_PATH) {
		if($name === 'list') {
			if($this->action === 'list-thieu-nhi') {
				$name = 'thieuNhi';
			} elseif($this->action === 'list-thieu-nhi-nhom') {
				$name                 = 'thieuNhiNhom';
				$parameters['phanBo'] = $this->actionParams['phanBo']->getId();
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
			->addIdentifier('code')
//			->addIdentifier('christianname', null, array())
			->addIdentifier('name', null, array())
			->add('dob', null, array( 'editable' => true ))
			->add('soDienThoai', null, array(
				'label'    => 'list.label_so_dien_thoai',
				'editable' => true
			))
			->add('soDienThoaiSecours', null, array(
				'label'    => 'list.label_so_dien_thoai_secours',
				'editable' => true
			))
			->add('diaChiThuongTru', null, array(
				'label'    => 'list.label_dia_chi_thuong_tru',
				'editable' => true
			))
			->add('chiDoan', 'choice', array(
				'editable' => false,
//				'class' => 'Vendor\ExampleBundle\Entity\ExampleStatus',
				'choices'  => $danhSachChiDoan,
			))
			->add('namHoc', 'text', array( 'editable' => false ))
			->add('enabled', null, array( 'editable' => false, 'label' => 'list.label_active' ))
			->add('_action', 'actions', array(
				'actions' => array(
					'edit' => array(),
//					'delete' => array(),
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
		
		$user                                    = $container->get('app.user')->getUser();
		$thanhVien                               = $user->getThanhVien();
		ThanhVienAdminHelper::$translationDomain = $this->translationDomain;
		if($isAdmin) {
			ThanhVienAdminHelper::configureAdminForm($formMapper, $this);
		} elseif( ! empty($phanBoNamNay = $thanhVien->getPhanBoNamNay()) && $phanBoNamNay->isChiDoanTruong()) {
			ThanhVienAdminHelper::configureChiDoanTruongForm($formMapper, $this);
		}
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
			$object->setSex(ThanhVien::$christianNameSex[ $christianName ]);
		}
		$object->setChristianname($christianName);
		$lastname   = $object->getLastname() ?: '';
		$middlename = $object->getMiddlename() ?: '';
		$firstname  = $object->getFirstname() ?: '';
		$object->setName($christianName . ' ' . $lastname . ' ' . $middlename . ' ' . $firstname);
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