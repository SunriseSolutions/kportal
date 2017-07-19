<?php
namespace AppBundle\Controller\User;
use AppBundle\Form\UserContactInfoType;
use Bean\Bundle\LocationBundle\Form\Type\GoogleMapType;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * This class is inspired from the FOS Profile Controller, except :
 *   - only twig is supported
 *   - separation of the user authentication form with the profile form.
 */
class ProfileFOSUser2Controller extends Controller
{
    /**
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function showAction()
    {
//        $user = $this->getUser();
//        if (!is_object($user) || !$user instanceof UserInterface) {
//            throw new AccessDeniedException('This user does not have access to this section.');
//        }
        $user = $this->get('app.user')->getUser();
        $primaryAddress = $user->getAddresses()->first();

        $summaryForm = $this->createFormBuilder()
            ->add('summary', CKEditorType::class, array(
                'data' => $user->getProfile()->getSummary(),
                'config_name' => 'user_edit',
                'label' => 'Introduce yourself and describe your career objectives',
                'attr' => ['rows' => '5', 'maxlength' => '5000', 'class' => 'form-control countdown-target']
            ))
            ->getForm();

        $contactForm = $this->createForm(UserContactInfoType::class);

        $tagManager = $this->get('sonata.classification.manager.tag');
        $skills = $tagManager->findBy(['enabled' => true,'context'=>$this->getParameter('job_skill_context')],null,300);

        return $this->render('SonataUserBundle:Profile:show.html.twig', [
            'skillDb' => $skills,
            'contactForm' => $contactForm->createView(),
            'summaryForm' => $summaryForm->createView(),
            'class' => ['body' => 'job-profile-pg page-loader-2'], //
            'user' => $user,
            'blocks' => $this->container->getParameter('sonata.user.configuration.profile_blocks'),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return null|RedirectResponse|Response
     */
    public function editAuthenticationAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $event = new GetResponseUserEvent($user, $request);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');
        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);
            $this->setFlash('sonata_user_success', 'profile.flash.updated');
            $response = new RedirectResponse($this->generateUrl('sonata_user_profile_show'));

            return $response;
        }

        return $this->render('SonataUserBundle:Profile:edit_authentication.html.twig', [
            'form' => $form->createView(),
            'breadcrumb_context' => 'user_profile',
        ]);
    }

    /**
     * @param Request $request
     *
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function editProfileAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);
            $this->setFlash('sonata_user_success', 'profile.flash.updated');

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('sonata_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('SonataUserBundle:Profile:edit_profile.html.twig', [
            'form' => $form->createView(),
            'breadcrumb_context' => 'user_profile',
        ]);
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}
