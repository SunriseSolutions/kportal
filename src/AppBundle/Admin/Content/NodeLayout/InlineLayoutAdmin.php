<?php

namespace AppBundle\Admin\Content\NodeLayout;

use AppBundle\Admin\BaseAdmin;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

class InlineLayoutAdmin extends GenericLayoutAdmin {
	protected $parentAssociationMapping = 'rootContainer';
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id')
			->add('name');
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('name')
			->add('_action', 'actions', array(
				'actions' => array(
					'content_pieces' => array( 'template' => '::admin/content/layout/list__action__inline_layout_content_pieces.html.twig' ),
				)
			));
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		
		// define group zoning
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper->add('name');
		
		$formMapper->add('parent', ModelType::class, array(
//					'label' => 'form.label_work_location',
				'property' => 'name',
				
				'btn_add'     => false,
				'required'    => false,
				'constraints' => new Valid(),
				'multiple'    => false,
				'query'       => $this->getParentQuery()
			)
		);
		
		
		$formMapper
			->end()
			->end();
		
	}
}