<?php

namespace AppBundle\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\User\User;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Valid;

class ThanhVienAdminHelper {
	public static $translationDomain;
	
	public static function configureChiDoanTruongForm(FormMapper $formMapper) {
		$formMapper->tab('form.tab_info')
		           ->with('form.group_general', [ 'class' => 'col-md-6' ])->end()
		           ->with('form.group_extra', [ 'class' => 'col-md-6' ])->end()
			//->with('form.group_job_locations', ['class' => 'col-md-4'])->end()
			       ->end();
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('soDienThoai', null, array(
				'label'    => 'list.label_so_dien_thoai',
				'required' => false
			))
			->add('soDienThoaiSecours', null, array(
				'label'    => 'list.label_so_dien_thoai_secours',
				'required' => false
			))
			->add('diaChiThuongTru', null, array(
				'label'    => 'list.label_dia_chi_thuong_tru',
				'required' => true
			));
		
		$formMapper
			->end()
			->with('form.group_extra')//            ->add('children')
		;
		
		$formMapper->end()->end();
	}
	
	public static function configureAdminForm(FormMapper $formMapper) {
		
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
				'translation_domain' => self::$translationDomain
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
				'label'              => 'list.label_phan_doan',
				'placeholder'        => 'Chọn Phân Đoàn',
				'choices'            => ThanhVien::$danhSachPhanDoan,
				'translation_domain' => self::$translationDomain
			))
			->add('chiDoan', ChoiceType::class, array(
				'label'              => 'list.label_chi_doan',
				'placeholder'        => 'Chọn Chi Đoàn',
				'choices'            => $danhSachChiDoan,
				'translation_domain' => self::$translationDomain
			))
			->add('namHoc', null, array(
				'label'    => 'list.label_nam_hoc',
				'required' => true
			))
			->add('huynhTruong', null, array(
				'label' => 'list.label_huynh_truong',
			))
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
}