<?php

namespace AppBundle\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ThanhVienAdmin extends BaseAdmin {
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('christianname', null, array())
			->add('firstname', null, array())
			->add('middlename', null, array())
			->add('lastname', null, array());
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		
		$danhSachChiDoan = [
		'Chiên Con 4 tuổi' => 4,
		'Chiên Con 5 tuổi' => 5,
		'Chiên Con 6 tuổi' => 6,
		'Ấu Nhi 7 tuổi' => 7,
		'Ấu Nhi 8 tuổi' => 8,
		'Ấu Nhi 9 tuổi' => 9,
		'Thiếu Nhi 10 tuổi' => 10,
		'Thiếu Nhi 11 tuổi' => 11,
		'Thiếu Nhi 12 tuổi' => 12,
		'Nghĩa Sĩ 13 tuổi' => 13,
		'Nghĩa Sĩ 14 tuổi' => 14,
		'Nghĩa Sĩ 15 tuổi' => 15,
		'Tông Đồ 16 tuổi' => 16,
		'Tông Đồ 17 tuổi' => 17,
		'Tông Đồ 18 tuổi' => 18,
		'Dự Trưởng (19 tuổi)' => 19,
		];
		
		// define group zoning
		
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('christianname', ChoiceType::class, array(
				'required'           => true,
				'choices'            => ThanhVien::$christianNames,
				'translation_domain' => $this->translationDomain
			))
			->add('firstname', null, array())
			->add('middlename', null, array())
			->add('lastname', null, array())
			->add('phanDoan', ChoiceType::class, array(
				'choices'            => ThanhVien::$danhSachPhanDoan,
				'translation_domain' => $this->translationDomain
			))
			->add('chiDoan', ChoiceType::class, array(
				'placeholder'        => 'Chọn Chi Đoàn',
				'choices'            => $danhSachChiDoan,
				'translation_domain' => $this->translationDomain
			))
			->add('huynhTruong', null, array())
			->add('dob', DatePickerType::class, array(
				'format' => 'dd/MM/yyyy',
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