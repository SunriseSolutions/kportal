<?php

namespace AppBundle\Admin\Content\NodeLayout;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\GenericLayout;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GenericLayoutAdmin extends BaseAdmin {
	protected $parentAssociationMapping = 'rootContainer';
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id')
			->add('name');
	}
	
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
			->with('form.group_general')//            ->add('children')
			->add('name');
//		$formMapper
//			->add('children', null, array());
		
		$formMapper
			->end()
			->end();
		
	}
	
	protected function getParentQuery() {
		$pool = $this->getConfigurationPool();
		$request   = $this->getRequest();		/** @var QueryBuilder $parentQuery */
		$parentQuery = $this->getModelManager()->createQuery(GenericLayout::class);
		/** @var Expr $expr */
		$expr = $parentQuery->expr();
//				$sql = $childrenQuery->getQuery()->getSQL();
		/** @var GenericLayout $subject */
		$subject   = $this->getSubject();
		$rootAlias = $parentQuery->getRootAliases()[0];
		if($this->isAppendFormElement()) {
			// Indirect Parent
			$code       = $request->query->get('code');
			$objectId   = $request->query->get('objectId');
			$cNodeAdmin = $pool->getAdminByAdminCode($code);
			/** @var ContentNode $cNode */
			$cNode = $this->getModelManager()->find($cNodeAdmin->getClass(), $objectId);
			if(empty($cNode)) {
				$rootLayoutId = '';
			} else {
				$rootLayout   = $cNode->getLayout();
				$rootLayoutId = $rootLayout->getId();
			}
			$parentQuery->where($expr->eq($rootAlias . '.rootContainer', $expr->literal($rootLayoutId)));
			if( ! empty($subject)) {
				if( ! empty($subjectId = $subject->getId())) {
					$parentQuery->andWhere($expr->neq($rootAlias . '.id', $expr->literal($subjectId)));
				}
			}
		} else {
			// Indirect Parent but with direct access NOT Ajax call
			$cNodeAdmin = $pool->getAdminByAdminCode($request->attributes->get('_sonata_admin'));
			$objectId   = $request->attributes->get('id');
			/** @var ContentNode $cNode */
			$cNode = $this->getModelManager()->find($cNodeAdmin->getClass(), $objectId);
			if(empty($cNode)) {
				$rootLayoutId = '';
			} else {
				$rootLayout   = $cNode->getLayout();
				$rootLayoutId = $rootLayout->getId();
			}
			$parentQuery->andWhere($expr->eq($rootAlias . '.rootContainer', $expr->literal($rootLayoutId)));
			if( ! empty($subject)) {
				if( ! empty($subjectId = $subject->getId())) {
					$parentQuery->andWhere($expr->neq($rootAlias . '.id', $expr->literal($subjectId)));
				}
			}
		}
		
		return $parentQuery;
	}
}