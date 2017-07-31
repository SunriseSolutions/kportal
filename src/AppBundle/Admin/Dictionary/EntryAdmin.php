<?php

namespace AppBundle\Admin\Dictionary;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Dictionary\Entry;
use AppBundle\Entity\NLP\Sense;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntryAdmin extends BaseAdmin {
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('phrase', 'text', [ 'editable' => true ])
			->add('locale')
			->add('translation', null, [
				'template' => '::admin/dictionary/list__field_translation.html.twig'
			])
			->add('sense', null, array( 'associated_property' => 'abstract' ));
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		
		// define group zoning
		/** @var ProxyQuery $productQuery */
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general', [ 'class' => 'col-md-6' ])->end()
			->with('form.group_extra', [ 'class' => 'col-md-6' ])->end()
			//->with('form.group_job_locations', ['class' => 'col-md-4'])->end()
			->end();
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('locale', ChoiceType::class, array(
					'required'           => false,
					'choices'            => $this->getConfigurationPool()->getContainer()->getParameter('dictionary_locales'),
					'translation_domain' => $this->translationDomain,
					'expanded'           => true,
					'multiple'           => false
				)
			)
			->add('phrase', null, array())
			->add('sense', 'sonata_type_model_autocomplete', array(
				'property'           => 'data',
				'to_string_callback' => function(Sense $entity, $property) {
					return $entity->getId() . ':' . $entity->getAbstract();
				}
			))
			->add('phoneticSymbols', null, array( 'required' => false ))
			->add('audio', MediaType::class, [
//				'label'    => 'form.label_media',
				'required' => false,
				'provider' => 'sonata.media.provider.file',
				'context'  => 'ipa_audio'
			])
			->add('briefComment', null, array( 'required' => false ))
			->add('definition', TextareaType::class, array( 'required' => false ))



//			->add('slug', null, array())
//			->add('body', CKEditorType::class)
//			->add('htmlBody')
		;
		
		$formMapper
			->end();
		$formMapper
			->with('form.group_extra')//            ->add('children')
		;
		$formMapper->add('type', ChoiceType::class, array(
				'required'           => true,
				'choices'            => [
					Entry::TYPE_NOUN         => Entry::TYPE_NOUN,
					Entry::TYPE_VERB         => Entry::TYPE_VERB,
					Entry::TYPE_PHRASAL_VERB => Entry::TYPE_PHRASAL_VERB,
					Entry::TYPE_PREPOSITION  => Entry::TYPE_PREPOSITION,
					Entry::TYPE_SENTENCE     => Entry::TYPE_SENTENCE,
					Entry::TYPE_INTERJECTION => Entry::TYPE_INTERJECTION
				],
				'translation_domain' => $this->translationDomain,
				'expanded'           => true,
				'multiple'           => false
			)
		);
		$formMapper->end();
		$formMapper->end(); // end tab
		
	}
}