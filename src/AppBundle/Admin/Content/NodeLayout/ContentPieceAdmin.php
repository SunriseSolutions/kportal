<?php

namespace AppBundle\Admin\Content\NodeLayout;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\NodeLayout\ContentPiece;
use AppBundle\Entity\Content\NodeShortcode\ShortcodeFactory;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

class ContentPieceAdmin extends GenericLayoutAdmin {
	protected $parentAssociationMapping = 'layout';
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id');
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id');
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		/** @var ContentPiece $subject */
		$subject = $this->getSubject();
		if( ! empty($subject)) {
			$formatter = $subject->getFormatter();
		} else {
			$formatter = 'markdown';
		}
		// define group zoning
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('shortcodes', ChoiceType::class, array(
				'required'           => true,
				'choices'            => ShortcodeFactory::$supportedShortcodes,
				'multiple'           => true,
				'translation_domain' => $this->translationDomain
			))
			->add('content', 'sonata_formatter_type', array(
				'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
				'format_field'         => 'formatter',
				'format_field_options' => array(
					'choices' => array(
//						'twig'     => 'twig',
//						'text'     => 'text',
						'markdown' => 'markdown',
						'rawhtml'  => 'rawhtml',
						'richhtml' => 'richhtml'
					),
					'data'    => $formatter,
				),
				'source_field'         => 'raw',
				'source_field_options' => array(
					'attr' => array( 'class' => 'span10', 'rows' => 20 )
				),
//				'listener'             => false,
				'target_field'         => 'content'
			));
		
		
		$formMapper
			->end()
			->end();
		
	}
}