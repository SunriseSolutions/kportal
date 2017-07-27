<?php

namespace AppBundle\Admin\Content\NodeType\Article;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\NodeType\Article\ArticleNode;
use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
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