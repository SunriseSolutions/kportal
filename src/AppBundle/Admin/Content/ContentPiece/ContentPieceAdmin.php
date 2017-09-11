<?php

namespace AppBundle\Admin\Content\ContentPiece;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Admin\Content\NodeLayout\GenericLayoutAdmin;
use AppBundle\Entity\Content\ContentPiece\ContentPiece;
use AppBundle\Entity\Content\ContentPiece\ContentPieceVocabEntry;
use AppBundle\Entity\Content\NodeShortcode\ShortcodeFactory;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

class ContentPieceAdmin extends BaseAdmin {
	protected $parentAssociationMapping = 'layout';
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id',null,array('label'=>'list.label_id'))
			->add('name',null,array('label'=>'list.label_name'))
;
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->addIdentifier('name',null,['editable'=>true])
			->addIdentifier('layout.name')
		;
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
		$formMapper->add('name',null,array('label'=>'list.label_name'));
		$formMapper->add('vocabEntries', CollectionType::class,
			array(
				'required'    => false,
				
				'constraints' => new Valid(),
//					'label'       => false,
				//                                'btn_catalogue' => 'InterviewQuestionSetAdmin'
			), array(
				'edit'            => 'inline',
				'inline'          => 'table',
				//						        'sortable' => 'position',
				'link_parameters' => [],
				'admin_code'      => 'app.admin.content_layout_content_piece_vocab_entry',
				'delete'          => null,
			)
		);
		
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
	
	
	/**
	 * @param ContentPiece $object
	 */
	public function preValidate($object) {
		$vocabEntries = $object->getVocabEntries();
		/** @var ContentPieceVocabEntry $vocabEntry */
		foreach($vocabEntries as $vocabEntry) {
			$vocabEntry->setContentPiece($object);
		}
	}
}