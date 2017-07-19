<?php
namespace AppBundle\Controller\User;
use AppBundle\Entity\Position;
use Application\Sonata\UserBundle\Entity\User;
use Sonata\UserBundle\Controller\AdminSecurityController;

use FOS\UserBundle\Controller\SecurityController;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployerSecurityController extends SecurityController
{
    /**
     * @param Request $request
     *
     * @return Response|RedirectResponse
     */
    public function loginAction(Request $request)
    {
        if ($this->getUser() instanceof UserInterface) {
            $this->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');
            $url = $this->generateUrl('sonata_employer_dashboard');

            return $this->redirect($url);
        }

        $response = parent::loginAction($request);

        if ($this->isGranted('ROLE_EMPLOYER')) {
            $refererUri = $request->server->get('HTTP_REFERER');
            return $this->redirect($refererUri && $refererUri != $request->getUri() ? $refererUri : $this->generateUrl('sonata_employer_dashboard'));
        }

        return $response;
    }

    /**
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
    {
        return $this->render('SonataUserBundle:Employer:Security/login.html.twig', array_merge($data, [
            'base_template' => $this->get('sonata.admin.pool')->getTemplate('layout'),
            'admin_pool' => $this->get('sonata.admin.pool'),
            'reset_route' => $this->generateUrl('sonata_user_employer_resetting_request'),
        ]));
    }
}