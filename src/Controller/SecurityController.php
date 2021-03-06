<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class SecurityController extends Controller
{
	/**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
	{
    // get the login error if there is one
    $error = $authUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authUtils->getLastUsername();

    return $this->render('security/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
	}


    /**
     * @Route("/loginfront", name="loginfront")
     */
    public function loginfrontAction(Request $request, AuthenticationUtils $authUtils)
    {
    // get the login error if there is one
    $error = $authUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authUtils->getLastUsername();

    return $this->render('lucky/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
    }

/**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        
    }


     /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        
    }
}