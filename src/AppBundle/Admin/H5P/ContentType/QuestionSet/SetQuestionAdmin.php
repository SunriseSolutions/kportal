<?php

namespace AppBundle\Admin\H5P\ContentType\QuestionSet;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentType\DragQuestion\ContentDragQuestion;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use AppBundle\Entity\H5P\ContentType\QuestionSet\SetQuestion;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SetQuestionAdmin extends BaseAdmin {
	
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
			->add('h5pContent', 'sonata_type_model_autocomplete', array(
				'property'           => 'keywords',
				'to_string_callback' => function(Content $entity, $property) {
					return $entity->getTitle() . ' ' . $entity->getId();
				},
				'callback'           => function($admin, $property, $value) {
					$datagrid = $admin->getDatagrid();
					/** @var QueryBuilder $queryBuilder */
					$queryBuilder = $datagrid->getQuery();
					$expr         = $queryBuilder->expr();
					$queryBuilder
						->andWhere(
							$expr->orX(
								$expr->isInstanceOf($rootAlias = $queryBuilder->getRootAliases()[0], $expr->literal(ContentMultiChoice::class))
								,
								$expr->isInstanceOf($rootAlias, $expr->literal(ContentDragQuestion::class))
							)
						)
//						->andWhere(
//							$expr->like($rootAlias.'.keywords')
//						)
//						->setParameter('imageProviderName', 'sonata.media.provider.image')
//						->setParameter('youtubeProviderName', 'sonata.media.provider.youtube')
					;
					$datagrid->setValue($property, null, $value);
				},
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