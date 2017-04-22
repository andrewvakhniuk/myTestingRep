<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/28/2017
 * Time: 10:31 AM
 */
namespace AppBundle\Controller;
use FOS\UserBundle\Controller\SecurityController as BaseController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;


class SecurityController extends BaseController{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
//****** if authenticated user goes to login page it will redirect him to report_index
        $securityContext = $this->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('plan_index'));
        }
 /* ************* parent::loginAction() ******* */
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;



        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }
        //here check for blocked ip
        //$error=new AuthenticationException("blocked_ip",0,null);



        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }

}