<?php

namespace AppBundle\Admin\Content\ContentEntity;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\User\User;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IndividualEntityAdmin extends BaseAdmin {
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id')
			->add('slug');
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
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('slug', null, array())
			->add('owner', ModelAutocompleteType::class, array(
					'property'           => 'username',
					'to_string_callback' => function(User $entity, $property) {
						return $entity->getUsername() . ': ' . $entity->getFirstname() . ' ' . $entity->getLastname();
					}
				,
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
			);
		
		$formMapper
			->end()
			->end();
		
	}
}