<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/3/2017
 * Time: 12:53 PM
 */
// AuthenticationListener.php

namespace AppBundle\Listener;

use AppBundle\Entity\LoginHistory;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;


class AuthenticationListener implements EventSubscriberInterface
{
//  argument userManager is passed in service
    protected $userManager;
    protected $entityManager;
    protected $authenticationUtils;
    protected $container;


    //to get user it is not needed
    protected $tokenStorage;

    /**
     * AuthenticationListener constructor.
     * @param UserManagerInterface $userManager
     * @param EntityManager $entityManager
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationUtils $authenticationUtils
     * @param Container $container
     */
    public function __construct(UserManagerInterface $userManager, EntityManager $entityManager, TokenStorageInterface $tokenStorage,
                                AuthenticationUtils $authenticationUtils, Container $container){

        $this->userManager=$userManager;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->authenticationUtils = $authenticationUtils;
        $this->container = $container;
    }

    /**
     * getSubscribedEvents
     *
     * @return 	array
     */
    public static function getSubscribedEvents()
    {
        return array(
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
            SecurityEvents::INTERACTIVE_LOGIN  => 'onAuthenticationSuccess',
        );
    }

    /**
     * onAuthenticationFailure
     *
     * @param 	AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailure( AuthenticationFailureEvent $event )
    {
        // executes on failed login

        $request=$this->container->get('request_stack')->getCurrentRequest();
        //message
        $request->getSession()->getFlashBag()->add('info', "Failure, AuthenticationListener!");
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $user=$this->userManager->findUserByUsername($lastUsername);
//        24 HOurs ago
        $dayAgo=new \DateTime('now');
        $dayAgo->modify('-1 day');

        $loginHistory = new LoginHistory();
        $loginHistory->setIp($request->getClientIp());
        $loginHistory->setDateTime(new \DateTime('now'));
        $loginHistory->setSuccess(false);
        $loginHistory->setUserName($lastUsername);

        //queryBuilder: count failed logins of this user during last 24 hours
        $queryBuilder=$this->entityManager->createQueryBuilder();
        $queryBuilder->
            select('count(login_history.id)')->
            from('AppBundle:LoginHistory','login_history')->
            andWhere($queryBuilder->expr()->gte('login_history.dateTime', ':dayAgo'))->
            setParameter('dayAgo', $dayAgo)->
            andWhere($queryBuilder->expr()->eq('login_history.success', 0));

        //if user with such name exist then add user the loginHistory
        if ($user instanceof User) {
            $loginHistory->setUser($user);
            //save to database loginHistory instance with user

            //query where user== currentUser
            $queryBuilder->
                andWhere($queryBuilder->expr()->eq('login_history.user',':userId'))->
                setParameter('userId', $user->getId());
            $attempts=$queryBuilder->getQuery()->getSingleScalarResult();
            if($attempts>=2){
                $user->setEnabled(false);
                $request->getSession()->getFlashBag()->add('info', "Your account -".$lastUsername." has been blocked, ask Administrator to help you.");
            }else{
                $request->getSession()->getFlashBag()->add('info', (2-$attempts)." attempts left");
            }
//            error_log("Log In Denied: Wrong password for User #" . $user->getId()  . " (" . $user->getEmail() . ")");
        }
//        else {
//            //save to db loginHistory instance without user
//            error_log("Log In Denied: User doesn't exist: " . $lastUsername);
//        }
        $this->entityManager->persist($loginHistory);
        $this->entityManager->flush();
    }

    /**
     * onAuthenticationSuccess
     *
     * @param 	InteractiveLoginEvent $event
     */
    public function onAuthenticationSuccess( InteractiveLoginEvent  $event )
    {
        // executes on successful login
        $user = $event->getAuthenticationToken()->getUser();
        //success message
        $event->getRequest()->getSession()->getFlashBag()->add('info', "Success, AuthenticationListener!");

        if ($user instanceof User) {
            $loginHistory = new LoginHistory();
            $loginHistory->setUser($user);
            $loginHistory->setUserName($user->getUsername());
            $loginHistory->setIp($event->getRequest()->getClientIp());
            $loginHistory->setDateTime(new \DateTime('now'));
            $loginHistory->setSuccess(true);
            // persist loginHistory instance to db
            $this->entityManager->persist($loginHistory);
            $this->entityManager->flush();
        }
//         return new Response();
    }
}