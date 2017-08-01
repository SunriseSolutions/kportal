<?php

namespace AppBundle\Admin\Dictionary;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Dictionary\Entry;
use AppBundle\Entity\NLP\Sense;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntryUsageAdmin extends BaseAdmin {
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id');
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		
		// define group zoning
		/** @var ProxyQuery $productQuery */
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general', [])->end()
//			->with('form.group_general', [ 'class' => 'col-md-6' ])->end()
//			->with('form.group_extra', [ 'class' => 'col-md-6' ])->end()
			//->with('form.group_job_locations', ['class' => 'col-md-4'])->end()
			->end();
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('usage', ModelAutocompleteType::class, array(
				'label'              => 'form.label_example_entry',
				'property'           => 'phrase',
				'to_string_callback' => function(Entry $entity, $property) {
					return $entity->getPhrase() . ':' . $entity->getBriefComment();
				},
				'required'           => true
			))
//			->add('slug', null, array())
//			->add('body', CKEditorType::class)
//			->add('htmlBody')
		;
		
		$formMapper
			->end();
		$formMapper->end(); // end tab
		
	}
}