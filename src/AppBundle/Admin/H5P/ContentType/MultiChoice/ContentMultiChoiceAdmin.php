<?php

namespace AppBundle\Admin\H5P\ContentType\MultiChoice;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use AppBundle\Entity\H5P\Library;
use Doctrine\Common\Collections\ArrayCollection;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContentMultiChoiceAdmin extends BaseAdmin {
	
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
			->add('multichoiceMedia', 'sonata_type_admin');
		
		$formMapper
			->end()
			->end();
		
	}
	
	/**
	 * @param ContentMultiChoice $object
	 */
	public function preValidate($object) {
		parent::preValidate($object);
//		$object->setParameters('test Params');
//		$object->setFiltered('test Params');
		$container = $this->getConfigurationPool()->getContainer();
		$libRepo   = $container->get('doctrine')->getRepository(Library::class);
		$libraries = [];
		foreach($object->getLibraries() as $lib) {
			$libraries[] = $libRepo->findOneBy([
				'machineName'  => $lib['machineName'],
				'majorVersion' => $lib['majorVersion'],
				'minorVersion' => $lib['minorVersion'],
				'patchVersion' => $lib['patchVersion'],
			]);
		}
		$object->initiateDependencies($libraries);
//		$media = $object->getMultichoiceMedia();
//		$stop = $media;
	}
}