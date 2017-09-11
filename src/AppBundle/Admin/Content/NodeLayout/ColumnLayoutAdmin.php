<?php

namespace AppBundle\Admin\Content\NodeLayout;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\ColumnLayout;
use AppBundle\Entity\Content\NodeLayout\GenericLayout;
use AppBundle\Entity\Content\NodeLayout\RootLayout;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

class ColumnLayoutAdmin extends GenericLayoutAdmin {
	protected $parentAssociationMapping = 'rootContainer';
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id')
			->add('name');
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id');
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		$spanChoices = [
			'1'  => 1,
			'2'  => 2,
			'3'  => 3,
			'4'  => 4,
			'5'  => 5,
			'6'  => 6,
			'7'  => 7,
			'8'  => 8,
			'9'  => 9,
			'10' => 10,
			'11' => 11,
			'12' => 12,
		];
		$screenSizes = [
			ColumnLayout::SCREEN_PHONE          => 1,
			ColumnLayout::SCREEN_TABLET         => 2,
			ColumnLayout::SCREEN_DESKTOP        => 3,
			ColumnLayout::SCREEN_LARGER_DESKTOP => 4,
		];
		
		$alignments = [
			ColumnLayout::ALIGN_LEFT   => ColumnLayout::ALIGN_LEFT,
			ColumnLayout::ALIGN_CENTER => ColumnLayout::ALIGN_CENTER,
			ColumnLayout::ALIGN_RIGHT  => ColumnLayout::ALIGN_RIGHT,
		];
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper->add('name',null, array(
			'label'=>'list.label_name'
		));
		
		$formMapper
		           ->add('span', ChoiceType::class, array(
			           'required'           => true,
			           'choices'            => $spanChoices,
			           'translation_domain' => $this->translationDomain
		           ))
		           ->add('screenSize', ChoiceType::class, array(
			           'required'           => true,
			           'choices'            => $screenSizes,
			           'translation_domain' => $this->translationDomain
		           ))
		           ->add('textAlign', ChoiceType::class, array(
			           'placeholder'        => '---',
			           'required'           => true,
			           'choices'            => $alignments,
			           'translation_domain' => $this->translationDomain
		           ))
		           ->add('position', null, array(
			           'translation_domain' => $this->translationDomain
		           ));
		$formMapper->add('parent', ModelType::class, array(
//					'label' => 'form.label_work_location',
				'property'           => 'name',
				'translation_domain' => $this->translationDomain,
				'btn_add'            => false,
				'required'           => false,
				'constraints'        => new Valid(),
				'multiple'           => false,
				'query'              => $this->getParentQuery()
			)
		);
		
		
		$formMapper
			->end()
			->end();
		
	}
}