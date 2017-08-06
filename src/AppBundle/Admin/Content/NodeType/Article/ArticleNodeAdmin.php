<?php

namespace AppBundle\Admin\Content\NodeType\Article;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\NodeLayout\ColumnLayout;
use AppBundle\Entity\Content\NodeLayout\ContentPiece;
use AppBundle\Entity\Content\NodeLayout\GenericLayout;
use AppBundle\Entity\Content\NodeLayout\InlineLayout;
use AppBundle\Entity\Content\NodeLayout\RootLayout;
use AppBundle\Entity\Content\NodeLayout\RowLayout;
use AppBundle\Entity\Content\NodeType\Article\ArticleNode;
use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Valid;

class ArticleNodeAdmin extends BaseAdmin {
	
	/**
	 * @param ArticleNode $object
	 */
	public function toString($object) {
		return ($object->getTitle()) ?: $object->getTopic();
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('slug', 'text', [ 'editable' => true ])
			->add('_action', 'actions', array(
				'actions' => array(
//                'show' => array(),
//                    'edit' => array(),
					'inline_layouts' => array( 'template' => '::admin/content/list__action__node_inline_layouts.html.twig' ),
				)
			));
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
		
		
		/** @var ArticleNode $subject */
		$subject = $this->getSubject();
		
		// define group zoning
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general', [ 'class' => 'col-md-6' ])->end()
			->with('form.group_extra', [ 'class' => 'col-md-6' ])->end()
			//->with('form.group_job_locations', ['class' => 'col-md-4'])->end()
			->end()
			->tab('form.tab_layout_grid')
			->with('form.group_column', [ 'class' => 'col-md-7' ])->end()
			->with('form.group_row', [ 'class' => 'col-md-5' ])->end()
			->end()
			->tab('form.tab_layout_inline')
			->with('form.group_general', [ 'class' => 'col-md-12' ])->end()
			//->with('form.group_job_locations', ['class' => 'col-md-4'])->end()
			->end();
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
			->add('title', null, array())
			->add('topic', null, array())
			->add('slug', null, array())
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
		if( ! empty($subject)) {
			if( ! empty($subject->getId())) {
				$rootLayoutId = $subject->getLayout()->getId();
				/** @var QueryBuilder $childrenQuery */
				$childrenQuery = $this->getModelManager()->createQuery(GenericLayout::class);
				/** @var Expr $expr */
				$expr = $childrenQuery->expr();
				$childrenQuery->where($expr->eq($childrenQuery->getRootAliases()[0] . '.rootContainer', $expr->literal($rootLayoutId)));
//				$sql = $childrenQuery->getQuery()->getSQL();
				$formMapper->add('layout.children', ModelType::class, array(
//					'label' => 'form.label_work_location',
						'property' => 'name',
						
						'btn_add'     => false,
						// todo: errrrrr this is just not working
						'required'    => false,
						'constraints' => new Valid(),
						'multiple'    => true,
						'query'       => $childrenQuery
					)
				);
			}
		}
		
		
		$formMapper
			->end()
			->end();
		$formMapper
			->tab('form.tab_layout_grid')
			->with('form.group_column');
		
		$formMapper->add('layout.columns', CollectionType::class,
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
				'admin_code'      => 'app.admin.content_layout_column',
				'delete'          => null,
			)
		);
		$formMapper->end();
		$formMapper->with('form.group_row');
		$formMapper->add('layout.rows', CollectionType::class,
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
				'admin_code'      => 'app.admin.content_layout_row',
				'delete'          => null,
			)
		);
		$formMapper
			->end()
			->end();
		
		$formMapper
			->tab('form.tab_layout_inline')
			->with('form.group_general');
		$formMapper->add('layout.inlineLayouts', CollectionType::class,
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
				'admin_code'      => 'app.admin.content_layout_inline',
				'delete'          => null,
			)
		)

//			->add('main', CKEditorType::class, [
//				'label' => 'form.label_main_content'
//			])
//			->add('bottomLeft', CKEditorType::class)
//			->add('bottomRight', CKEditorType::class)

//			->add('body', CKEditorType::class)
//			->add('htmlBody')
		;
		
		$formMapper
			->end()
			->end();
		
	}
	
	/** @param  ArticleNode $instance */
	public function setSubject($instance) {
		parent::setSubject($instance);
		if(empty($instance->getLayout())) {
			$instance->setLayout(new RootLayout());
		}
	}
	
	public function getNewInstance() {
		/** @var ArticleNode $instance */
		$instance = parent::getNewInstance();
		if(empty($instance->getLayout())) {
			$instance->setLayout(new RootLayout());
		}
		
		return $instance;
	}
	
	/**
	 * @param ArticleNode $object
	 */
	public function preValidate($object) {

//
		$layout         = $object->getLayout();
		$layoutChildren = $layout->getChildren();
		/** @var GenericLayout $child */
		foreach($layoutChildren as $child) {
			$child->setRoot($layout);
		}
		
		$columns = $object->getColumns();
		/** @var ColumnLayout $column */
		foreach($columns as $column) {
			$column->setRootContainer($object->getLayout());
		}
		
		$rows = $object->getRows();
		/** @var RowLayout $row */
		foreach($rows as $row) {
			$row->setRootContainer($object->getLayout());
		}
		
		$inlineLayouts = $object->getInlineLayouts();
		/** @var InlineLayout $layout */
		foreach($inlineLayouts as $layout) {
			$layout->setRootContainer($object->getLayout());
		}
		
		$object->setContent($object->getLayout()->buildHtml());
	}
	
	/**
	 * @param ArticleNode $object
	 */
	public function postPersist($object) {

//		$container->get( 'app.admin.candidate' )->update( $candidate );
//		$this->getModelManager()->update( $object );
		$this->updateProperties($object);
	}
	
	/**
	 * @param ArticleNode $object
	 */
	public function postUpdate($object) {

//		$container->get( 'app.admin.candidate' )->update( $candidate );
//		$this->getModelManager()->update( $object );
//		$this->getModelManager()->update( $object );
		$this->updateProperties($object);
	}
	
	private function updateProperties(ArticleNode $object) {
		$inlineLayouts = $object->getInlineLayouts();
		$h5pIds        = [];
		/** @var InlineLayout $layout */
		foreach($inlineLayouts as $layout) {
			/** @var ContentPiece $piece */
			foreach($layout->getContentPieces() as $piece) {
				if( ! empty($piece->getH5pContent())) {
					$h5pIds = array_merge($h5pIds, $piece->getH5pContent());
				}
			}
		}
		$object->setH5pContent($h5pIds);
		$this->getModelManager()->update($object);
	}
}