<?php

namespace AppBundle\Admin\H5P\ContentType\MultiChoice;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use AppBundle\Entity\H5P\ContentType\MultiChoice\MultiChoiceAnswer;
use AppBundle\Entity\H5P\Library;
use Doctrine\Common\Collections\ArrayCollection;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

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
			->add('multichoiceMedia', 'sonata_type_admin')
			->add('answers', CollectionType::class,
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
					'admin_code'      => 'app.admin.h5p.content_multichoice_answer',
					'delete'          => null,
				)
			);
		
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
		$answers = $object->getAnswers();
		/** @var MultiChoiceAnswer $answer */
		foreach($answers as $answer) {
			$object->addAnswer($answer);
		}
	}
}