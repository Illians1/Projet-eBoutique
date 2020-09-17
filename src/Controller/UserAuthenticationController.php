<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserAuthenticationController extends AbstractController
{
    /**
     * @Route("/user/authentication", name="user_authentication")
     */
    public function index()
    {
        return $this->render('user_authentication/index.html.twig', [
            'controller_name' => 'UserAuthenticationController',
        ]);
    }
}
