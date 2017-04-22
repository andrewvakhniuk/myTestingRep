<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/9/2017
 * Time: 4:32 PM
 */
namespace AppBundle\Listener;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Console\Output\ConsoleOutput;

class AccessDeniedListener
{
    protected $_session;
    protected $_router;
    protected $_container;
    public function __construct(Session $session, Router $router, Container $container)
    {
        $this->_session = $session;
        $this->_router = $router;
        $this->_container = $container;
    }
    public function onAccessDeniedException(GetResponseForExceptionEvent $event)
    {
//        $output= new ConsoleOutput();
//        $output->write("blocked_ip");
//        this exception is thrown in ClientIpVoter to block ip
        if ($event->getException()->getMessage() == 'ERROR_BLOCKED_IP_AppBundle/Security/Authorization/Voter/ClientIpVoter')
        {
            $route = $this->_router->generate('blocked_ip');
            $event->setResponse(new RedirectResponse($route));
        }
    }
}