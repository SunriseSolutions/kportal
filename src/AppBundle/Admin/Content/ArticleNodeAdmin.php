<?php

namespace AppBundle\Admin\Content;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\ArticleNode;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

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
			->add('main', CKEditorType::class, [
				'label' => 'form.label_main_content'
			])
			->add('bottomLeft', CKEditorType::class)
			->add('bottomRight', CKEditorType::class)

//			->add('body', CKEditorType::class)
//			->add('htmlBody')
		;
		
		$formMapper
			->end()
			->end();
		
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
		$stringService = $this->getConfigurationPool()->getContainer()->get('app.string');
		
		$shortcodeCount    = 0;
		$htmlReplaceFormat = '<button data-h5ptarget="%1$d" class="btn-content btn btn-default">%3$s</button> <br/>  <div class="h5p-content hidden" id="h5p_%1$d" data-content-id="%2$s"></div>';
		$h5pIds            = [];
		while( ! empty($shortcodeData = $stringService->parseShortCode($bodyContent, 'h5p'))) {
			$shortcodeCount ++;
			
			$htmlReplace = sprintf($htmlReplaceFormat, $shortcodeCount, $shortcodeData['attributes']['id'], $shortcodeData['attributes']['label']);
			
			$bodyContent                    = str_replace($shortcodeData['tag'], $htmlReplace, $bodyContent);
			$h5pIds[ $shortcodeData['attributes']['id'] ] = null;
		}
		
		$object->setHtmlBody($bodyContent);
		$object->setH5pContent($h5pIds);
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