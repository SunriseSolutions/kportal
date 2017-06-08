<?php

namespace AppBundle\Admin\Content;

use AppBundle\Admin\BaseAdmin;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ContentNodeAdmin extends BaseAdmin {
	
	protected function configureListFields( ListMapper $listMapper ) {
		$listMapper
			->addIdentifier( 'id' )
			->add( 'slug', 'text', [ 'editable' => true ] );
	}
	
	protected function configureFormFields( FormMapper $formMapper ) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		
		// define group zoning
		/** @var ProxyQuery $productQuery */
		$formMapper
			->tab( 'form.tab_company_info' )
			->with( 'form.group_general' )//            ->add('children')
		;
		$formMapper
			->add( 'owner', null, array() )
			->add( 'slug', null, array() )
			->add('body', CKEditorType::class)
		
		;
		
		$formMapper
			->end()
			->end();
		
	}
}