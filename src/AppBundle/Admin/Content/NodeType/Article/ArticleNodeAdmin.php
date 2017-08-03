<?php

namespace AppBundle\Admin\Content\NodeType\Article;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\NodeLayout\ColumnLayout;
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
			->add('slug', 'text', [ 'editable' => true ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		/** @var ArticleNode $subject */
		$subject = $this->getSubject();
		// define group zoning
		/** @var ProxyQuery $productQuery */
		$formMapper
			->tab('form.tab_main_body_info')
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
		)
			->add('layout.rows', CollectionType::class,
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
			)
			
			->add('layout.inlineLayouts', CollectionType::class,
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
		$bodyContent = '
                            <div class="row">
                                <div class="col-sm-12">
                                %s
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-lg-6">
                                %s
                                </div>
                                <div class="col-lg-6">
                                %s
                                </div>
                            </div>';
		
		$bodyContent = sprintf($bodyContent, $object->getMain(), $object->getBottomLeft(), $object->getBottomRight());
		
		$object->setBody($bodyContent);
		
		$container      = $this->getConfigurationPool()->getContainer();
		$stringService  = $container->get('app.string');
		$h5pService     = $container->get('app.h5p');
		$h5pContentRepo = $container->get('doctrine')->getRepository(Content::class);
		$shortcodeCount = 0;
		
		$h5pIds = [];
		while( ! empty($shortcodeData = $stringService->parseShortCode($bodyContent, 'h5p'))) {
			$shortcodeCount ++;
			/** @var Content $content */
			$content = $h5pContentRepo->find($shortcodeData['attributes']['id']);
			if( ! empty($content)) {
				$embed      = $h5pService->getContentActualEmbedType($content);
				$hideOnLoad = $embed === 'div';
				if($content instanceof ContentMultiChoice) {
					if( ! empty($media = $content->getMultichoiceMedia())) {
						if($media->isYoutube()) {
							$hideOnLoad &= false;
						}
					}
				}
				$htmlReplaceFormat = '<button data-h5ptarget="%1$d" class="btn-content btn btn-default">%2$s</button> <br/> ' . $h5pService->getContentHtml($content, [
						'class' => $hideOnLoad ? 'hidden' : 'h5p-app-active',
						'id'    => 'h5p_%1$d'
					]);
				
				$htmlReplace = sprintf($htmlReplaceFormat, $shortcodeCount, $shortcodeData['attributes']['label']);
				
				$bodyContent                                  = str_replace($shortcodeData['tag'], $htmlReplace, $bodyContent);
				$h5pIds[ $shortcodeData['attributes']['id'] ] = null;
				
			} else {
				$bodyContent = str_replace($shortcodeData['tag'], '', $bodyContent);
			}
		}
		
		$object->setHtmlBody($bodyContent);
		$object->setH5pContent($h5pIds);
		
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
		
	}
	
	/**
	 * @param ArticleNode $object
	 */
	public function postPersist($object) {

//		$container->get( 'app.admin.candidate' )->update( $candidate );
//		$this->getModelManager()->update( $object );
//		$this->getModelManager()->update( $object );
		
	}
	
	/**
	 * @param ArticleNode $object
	 */
	public function postUpdate($object) {

//		$container->get( 'app.admin.candidate' )->update( $candidate );
//		$this->getModelManager()->update( $object );
//		$this->getModelManager()->update( $object );
		
	}
	
}