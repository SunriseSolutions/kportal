<?php

namespace AppBundle\Admin\H5P\ContentType\MultiChoice;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceMedia;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MultiChoiceMediaAdmin extends BaseAdmin {
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('title', 'text', [ 'editable' => true ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
//			->add('content')
//			->add('media', MediaType::class, [
//				'label' => 'form.label_media',
//				'required' => false,
//				'provider' => 'sonata.media.provider.image',
//				'context' => 'default'
//			])
			->add('media', 'sonata_type_model_autocomplete', array(
				'property' => 'name'
			));
		
		$formMapper
			->end()
			->end();
		
	}
	
}