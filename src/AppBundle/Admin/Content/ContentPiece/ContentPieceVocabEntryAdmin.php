<?php

namespace AppBundle\Admin\Content\ContentPiece;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\NodeLayout\ContentPiece;
use AppBundle\Entity\Content\NodeLayout\ContentPieceVocabEntry;
use AppBundle\Entity\Content\NodeShortcode\ShortcodeFactory;
use AppBundle\Entity\Dictionary\Entry;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

class ContentPieceVocabEntryAdmin extends BaseAdmin {
//	protected $parentAssociationMapping = 'layout';
	
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
		/** @var ContentPieceVocabEntry $subject */
		$subject = $this->getSubject();
		
		// define group zoning
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		
		$formMapper
			->add('entry', ModelAutocompleteType::class, array(
				'label'              => 'form.label_example_entry',
				'property'           => 'phrase',
				'to_string_callback' => function(Entry $entity, $property) {
					return $entity->getPhrase() . ' : ' . $entity->getBriefComment();
				},
				'required'           => true
			));
		
		
		$formMapper
			->end()
			->end();
		
	}
}