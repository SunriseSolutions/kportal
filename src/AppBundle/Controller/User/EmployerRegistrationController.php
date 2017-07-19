<?php
namespace AppBundle\Controller\User;

use AppBundle\Entity\Organisation;
use AppBundle\Entity\Position;
use Application\Bean\LocationBundle\Entity\Geolocation;
use Application\Bean\LocationBundle\Entity\OrganisationLocation;
use Application\Sonata\UserBundle\Entity\User;
use Bean\Bundle\LocationBundle\Form\Type\GoogleMapType;
use FOS\UserBundle\Controller\RegistrationController;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;

use FOS\UserBundle\Model\UserManagerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployerRegistrationController extends RegistrationController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request)
    {
        $errorMessages = [];
        $addressData = [];
        $form = $this->createFormBuilder()
            ->add('address', GoogleMapType::class, array(
                    'data' => $addressData,
                    'address_options' =>
                        array(
//                            'data' => $address->getAddress(),
                            'label' => false,
                            'attr' =>
                                ['class' => 'form-control'
                                ]
                        ),
                    'show_map' => false,
                    'label' => false
                )
            )
            ->getForm();

        if ($request->isMethod('POST')) {
            // user exists
            // position exists
            // position exists
            $orgName = $request->request->get('organisation-name', '');
            $firstName = $request->request->get('first-name', '');
            $lastName = $request->request->get('last-name', '');
            $phone = trim($request->request->get('user-phone', ''));
            $email = trim($request->request->get('email', ''));
            $password = $request->request->get('password', '');
            $passwordConfirmation = $request->request->get('password-confirmation', '');

            $valid = true;
            if (empty($orgName)) {
                $valid = false;
                $errorMessages[] = 'Company Name is required';
            }
            if (empty($phone)) {
                $valid = false;
                $errorMessages[] = 'Your Phone Number is required';
            }
            if (empty($firstName) || empty($lastName)) {
                $valid = false;
                $errorMessages[] = 'First and Last Name is required';
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $valid = false;
                $errorMessages[] = 'Invalid Email Address';
            }
            if (empty($password)) {
                $valid = false;
                $errorMessages[] = 'Please enter a password';
            }
            if ($password !== $passwordConfirmation) {
                $valid = false;
                $errorMessages[] = 'Password mismatch';
            }

            $form->handleRequest($request);
            $formData = $form->getData();
            $address = $formData['address'];
            if (empty($address)) {
                $valid = false;
                $errorMessages[] = 'Address is required';
            }
            if ($valid) {
                $manager = $this->getDoctrine()->getManager();
                $userManager = $this->get('app.sonata_user.user_manager');
                $user = $userManager->findOneBy(['email' => $email]);
                $location = new Geolocation();
                $location->setGeolocation($address);
                $location = $this->get('bean_location.manager.location')->save($location);
                if (empty($user)) {
                    $user = new User();
                    $user->setEnabled(true);
                    $user->setFirstname($firstName);
                    $user->setLastname($lastName);
                    $user->setUsername($email);
                    $user->setEmail($email);
                    $user->setPhone($phone);
                    $user->setPlainPassword($password);
                    $userManager->updateUser($user);
                }

                /**
                 * What happens if there are multiple employees workin for multiple coys
                 */
                if (empty($user->getPosition())) {
                    if (!$user->hasRole('ROLE_EMPLOYER')) {
                        $user->addRole('ROLE_EMPLOYER');
                    }
                    $orgLocation = new OrganisationLocation();
                    $orgLocation->setGeolocation($location);

                    $org = new Organisation();
                    $org->setName($orgName);
                    $org->setEnabled(true);
                    $org->addLocation($orgLocation);

                    $manager->persist($org);
                    $pos = $user->registerEmployer($org);
                    $userManager->updateUser($user, false);
                    $manager->persist($pos);
                    $manager->flush();
                }
                $this->get('app.user')->logUserIn($user);
                return new RedirectResponse($this->generateUrl('sonata_employer_dashboard'));
            }
            $formData['organisation-name'] = $orgName;
            $formData['first-name'] = $firstName;
            $formData['last-name'] = $lastName;
            $formData['user-phone'] = $phone;
            $formData['email'] = $email;

        } else {
            $formData = array(
                'organisation-name' => '',
                'first-name' => '',
                'last-name' => '',
                'user-phone' => '',
                'email' => ''
            );
        }

        $data = array('form' => $form->createView(),
            'errors' => $errorMessages,
            'data' => $formData
        );
        return $this->render('SonataUserBundle:Employer/Registration:register.html.twig', array_merge($data, ['base_template' => $this->get('sonata.admin.pool')->getTemplate('layout'),
            'admin_pool' => $this->get('sonata.admin.pool'),
            'reset_route' => $this->generateUrl('sonata_user_employer_resetting_request'),]));
    }

}