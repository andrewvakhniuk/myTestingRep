<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/16/2017
 * Time: 11:00 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use AppBundle\Form\EmployeeType;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Console\Output\ConsoleOutput;

class RegistrationController extends BaseController
{
//    this controller action overrides action from FOS/UserBundle/Controller/Registration: RegisterAction
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request)
    {
//        $output=new ConsoleOutput();
//        $output->writeln("controller registration is overrided !!");
//        /** @var $formFactory FactoryInterface */
//        $formFactory = $this->get('fos_user.registration.form.factory');
//        /** @var $userManager UserManagerInterface */
//        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $employee = new Employee();

        $event = new GetResponseUserEvent($employee, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
//adding to DB
//                $output->writeln($form->get('role')->getData());
                $employee->setEnabled(true);
                $employee->addRole($form->get('role')->getData());
                $em = $this->getDoctrine()->getManager();
                $em->persist($employee);
                $em->flush();

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_profile_show');
                    $response = new RedirectResponse($url);
                }
//                do not authenticate user
                //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($employee, $request, $response));

                return $response;
            }
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }
        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}