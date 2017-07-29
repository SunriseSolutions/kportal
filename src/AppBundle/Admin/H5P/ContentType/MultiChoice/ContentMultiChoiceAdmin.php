<?php

namespace AppBundle\Admin\H5P\ContentType\MultiChoice;

use AppBundle\Admin\BaseAdmin;
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
			->add('questionText')
			->add('slug', null, array(
				'required' => false
			))
			->add('keywords', null, array(
				'required' => false
			))
			->add('autoCheckEnabled')
			->add('correctFeedbackText')
			->add('almostCorrectFeedbackText')
			->add('wrongFeedbackText')
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
		$locale    = $container->get('lunetics_locale.domain_guesser')->getIdentifiedLocale();
		$object->setLocale($locale);
		
		$trans = $container->get('translator');
		$trans->setLocale($locale);
		
		////// UI Settings /////
		$object->setCheckAnswerButtonText($trans->trans('ui.checkAnswerButton', [], 'BeanH5PBundle'));
		$object->setShowSolutionButtonText($trans->trans('ui.showSolutionButton', [], 'BeanH5PBundle'));
		$object->setTryAgainButtonText($trans->trans('ui.tryAgainButton', [], 'BeanH5PBundle'));
		$object->setTipLabelText($trans->trans('ui.tipsLabel', [], 'BeanH5PBundle'));
		$object->setScoreBarLabelText($trans->trans('ui.scoreBarLabel', [], 'BeanH5PBundle'));
		$object->setTipAvailableText($trans->trans('ui.tipAvailable', [], 'BeanH5PBundle'));
		$object->setFeedbackAvailableText($trans->trans('ui.feedbackAvailable', [], 'BeanH5PBundle'));
		$object->setReadFeedbackText($trans->trans('ui.readFeedback', [], 'BeanH5PBundle'));
		$object->setWrongAnswerText($trans->trans('ui.wrongAnswer', [], 'BeanH5PBundle'));
		$object->setCorrectAnswerText($trans->trans('ui.correctAnswer', [], 'BeanH5PBundle'));
		$object->setFeedbackText($trans->trans('ui.feedback', [], 'BeanH5PBundle'));
		$object->setShouldCheckText($trans->trans('ui.shouldCheck', [], 'BeanH5PBundle'));
		$object->setShouldNotCheckText($trans->trans('ui.shouldNotCheck', [], 'BeanH5PBundle'));
		$object->setNoInputText($trans->trans('ui.noInput', [], 'BeanH5PBundle'));
		
		//////// Dialog Settings ////////
		$object->setConfirmCheckHeaderText($trans->trans('dialog.header_finish', [], 'BeanH5PBundle'));
		$object->setConfirmCheckBodyText($trans->trans('dialog.body_finish', [], 'BeanH5PBundle'));
		$object->setConfirmCheckCancelButtonText($trans->trans('dialog.cancel_label', [], 'BeanH5PBundle'));
		$object->setConfirmCheckConfirmButtonText($trans->trans('dialog.confirm_Label', [], 'BeanH5PBundle'));
		
		$object->setConfirmRetryHeaderText($trans->trans('dialog.header_retry', [], 'BeanH5PBundle'));
		$object->setConfirmRetryBodyText($trans->trans('dialog.body_retry', [], 'BeanH5PBundle'));
		$object->setConfirmRetryCancelButtonText($trans->trans('dialog.cancel_label', [], 'BeanH5PBundle'));
		$object->setConfirmRetryConfirmButtonText($trans->trans('dialog.confirm_Label', [], 'BeanH5PBundle'));
		
		$libRepo   = $container->get('doctrine')->getRepository(Library::class);
		$libraries = [];
		$object->setupLibraries();
//		$object->setMultichoiceMedia($object->getMultichoiceMedia());
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
		$answers = $object->getAnswers();
		/** @var MultiChoiceAnswer $answer */
		foreach($answers as $answer) {
			$answer->setQuestion($object);
		}
	}
	
	public function preUpdate($object) {
		parent::preUpdate($object);
		$object->setUpdatedAt(new \DateTime());
	}
}