<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/10/2017
 * Time: 10:23 PM
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ErrorController extends Controller
{
    public function blockedIpAction()
    {
        return $this->render('error/error_blocked_ip.html');
    }
    public function accessDeniedAction()
    {
        return $this->render('error/error_access_denied.html');
    }
}
