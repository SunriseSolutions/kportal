<?php
namespace AppBundle\Controller\Admin\User;

use AppBundle\Controller\Admin\BaseCRUDController;
use Application\Sonata\UserBundle\Admin\AppUserAdmin;
use Application\Sonata\UserBundle\Entity\User;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserController extends BaseCRUDController
{
    /** @var  AppUserAdmin $admin */
    protected $admin;

    public function showUserProfileAction($id = null)
    {
        $this->admin->setAction('show-user-profile');

        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('show', $object);

        $preResponse = $this->preShow($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        return $this->render($this->admin->getTemplate('show-user-profile'), array(
            'action' => 'show',
            'object' => $object,
            'elements' => $this->admin->getShow(),
        ), null);

    }

    /**
     * List action.
     *
     * @return Response
     *
     * @throws AccessDeniedHttpException If access is not granted
     */
    public function talentBankAction()
    {
        $this->admin->setAction('talent-bank');

        $request = $this->getRequest();

        $this->admin->checkAccess('list');

        $preResponse = $this->preList($request);
        if ($preResponse !== null) {
            return $preResponse;
        }

        if ($listMode = $request->get('_list_mode')) {
            $this->admin->setListMode($listMode);
        }

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('talent-bank'), array(
            'action' => 'list',
            'form' => $formView,
            'datagrid' => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ), null, $request);
    }

    public function editAction($id = null)
    {
        /** @var User $user */
        $user = $this->admin->getSubject();
        $pos = $this->get('app.user')->getPosition(); // default ???
        if (!$this->isAdmin()) {
            if (empty($pos) || !$user->isEmployeeOf($pos->getEmployer())) {
                throw new AccessDeniedHttpException('No persmission to edit this user');
            }
        }
        return parent::editAction($id);
    }
}