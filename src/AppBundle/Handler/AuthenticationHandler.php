<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/3/2017
 * Time: 11:39 AM
 */

namespace AppBundle\Handler;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationHandler implements AuthenticationFailureHandlerInterface, LogoutSuccessHandlerInterface
{
    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $referer = $request->headers->get('referer');
        $request->getSession()->getFlashBag()->add('info', "Failure Handler !");

        return new RedirectResponse($referer);
    }
    public function onLogoutSuccess(Request $request)
    {
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}