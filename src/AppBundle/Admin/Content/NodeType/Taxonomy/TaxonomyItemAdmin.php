<?php

namespace AppBundle\Admin\Content\NodeType\Taxonomy;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\NodeType\Article\ArticleNode;
use AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyItem;
use AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyNode;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Valid;

class TaxonomyItemAdmin extends BaseAdmin {
	
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('slug', 'text', [ 'editable' => true ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
		
		
		/** @var TaxonomyNode $subject */
		$subject = $this->getSubject();
		
		// define group zoning
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general', [ 'class' => 'col-md-12' ]);
		
		$formMapper
			->add('taxonomy', ModelAutocompleteType::class, array(
					'property'           => 'slug',
					'to_string_callback' => function(TaxonomyNode $entity, $property) {
						return $entity->getSlug() . ' - ' . $entity->getType();
					},
					'callback'           => function($admin, $property, $value) {
						$datagrid = $admin->getDatagrid();
						/** @var QueryBuilder $queryBuilder */
						$queryBuilder = $datagrid->getQuery();
						$expr         = $queryBuilder->expr();
						$queryBuilder
							->andWhere(
								$expr->eq($queryBuilder->getRootAliases()[0] . '.enabled', ':trueValue')
							)
							->setParameter('trueValue', true);
						$datagrid->setValue($property, null, $value);
					},
				)
			)

//			->add('layout.children', ModelAutocompleteType::class, array(
////				'label'              => 'form.label_example_entry',
//				'property'           => 'name',
//				'to_string_callback' => function(GenericLayout $entity, $property) {
//					return $entity->getName();
//				},
//				'required'           => true,
//				'multiple'           => true
//			))
		;
		
		
		$formMapper
			->end()
			->end();
		
	}
	
	/**
	 * @param TaxonomyItem $object
	 */
	public function preValidate($object) {
	}
	
	/**
	 * @param TaxonomyItem $object
	 */
	public function postPersist($object) {

//		$container->get( 'app.admin.candidate' )->update( $candidate );
//		$this->getModelManager()->update( $object );
		$this->updateProperties($object);
	}
	
	/**
	 * @param TaxonomyItem $object
	 */
	public function postUpdate($object) {

//		$container->get( 'app.admin.candidate' )->update( $candidate );
//		$this->getModelManager()->update( $object );
//		$this->getModelManager()->update( $object );
		$this->updateProperties($object);
	}
	
	private function updateProperties(TaxonomyItem $object) {
	}
}