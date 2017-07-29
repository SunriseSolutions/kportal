<?php

namespace AppBundle\Admin\H5P\ContentType\DragQuestion;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\H5P\ContentType\DragQuestion\ContentQuestionSet;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceAnswer;
use AppBundle\Entity\H5P\Dependency;
use AppBundle\Entity\H5P\Library;
use Doctrine\Common\Collections\ArrayCollection;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

class ContentDragQuestionAdmin extends BaseAdmin {
	
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
			->add('title')
			->add('slug', null, array(
				'required' => false
			))
			->add('keywords', null, array(
				'required' => false
			));
		
		$formMapper
			->end()
			->end();
		
	}
	
	/**
	 * @param ContentQuestionSet $object
	 */
	public function preValidate($object) {
		parent::preValidate($object);
//		$object->setParameters('test Params');
//		$object->setFiltered('test Params');
		$container = $this->getConfigurationPool()->getContainer();
		$locale    = $container->get('lunetics_locale.domain_guesser')->getIdentifiedLocale();
		$object->setLocale($locale);
		
		$trans = $container->get('translator');
		$trans->setLocale($locale);
		
		$libRepo   = $container->get('doctrine')->getRepository(Library::class);
		$libraries = [];
		$object->setupLibraries();
		
		$objLibs = $object->getLibraries();
		foreach($objLibs as $lib) {
			$library                   = array();
			$library['dependencyType'] = array_key_exists('dependencyType', $lib) ? $lib['dependencyType'] : Dependency::TYPE_PRELOADED;
			$library['object']         = $libRepo->findOneBy([
				'machineName'  => $lib['machineName'],
				'majorVersion' => $lib['majorVersion'],
				'minorVersion' => $lib['minorVersion'],
				'patchVersion' => $lib['patchVersion'],
			]);
			$libraries[]               = $library;
		}
		
		$object->initiateDependencies($libraries);
//		$media = $object->getMultichoiceMedia();
//		$stop = $media;
	}
	
	public function preUpdate($object) {
		parent::preUpdate($object);
		$object->setUpdatedAt(new \DateTime());
	}
}