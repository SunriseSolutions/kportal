<?php

namespace AppBundle\Admin\H5P\ContentType\MultiChoice;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceMedia;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MultiChoiceAnswerAdmin extends BaseAdmin {
	
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
			->add('text')
			->add('correct')
			->add('tip', CKEditorType::class, array(
					'config_name' => 'user_edit'
				)
			)
			->add('feedbackChosen', CKEditorType::class, array(
				'config_name' => 'user_edit'
			))
			->add('feedbackNotChosen', CKEditorType::class, array(
				'config_name' => 'user_edit'
			))

//			->add('media', MediaType::class, [
//				'label' => 'form.label_media',
//				'required' => false,
//				'provider' => 'sonata.media.provider.image',
//				'context' => 'default'
//			])
		;
		
		$formMapper
			->end()
			->end();
		
	}
	
}