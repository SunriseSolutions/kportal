<?php

namespace AppBundle\Admin\Content;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\ArticleNode;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArticleNodeAdmin extends BaseAdmin {
	
	/**
	 * @param ArticleNode $object
	 */
	public function toString($object) {
		return ($object->getTitle()) ?: $object->getTopic();
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('slug', 'text', [ 'editable' => true ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		
		// define group zoning
		/** @var ProxyQuery $productQuery */
		$formMapper
			->tab('form.tab_main_body_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('title', null, array())
			->add('topic', null, array())
			->add('slug', null, array())
			->add('main', CKEditorType::class, [
				'label' => 'form.label_main_content'
			])
			->add('bottomLeft', CKEditorType::class)
			->add('bottomRight', CKEditorType::class)

//			->add('body', CKEditorType::class)
//			->add('htmlBody')
		;
		
		$formMapper
			->end()
			->end();
		
	}
}