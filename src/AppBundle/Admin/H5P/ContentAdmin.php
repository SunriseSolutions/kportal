<?php

namespace AppBundle\Admin\H5P;

use AppBundle\Admin\BaseAdmin;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContentAdmin extends BaseAdmin {
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('title')
			->add('keywords')
		;
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('title', 'text', [ 'editable' => true ])
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('title', TextType::class, array())
			->add('topic', null, array());
		
		$formMapper
			->end()
			->end();
		
	}
}