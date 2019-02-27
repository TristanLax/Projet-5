<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{

    
    /**
     * @Route("/login", name="login.index")
     */
        public function index()
    {
        return $this->render('projet/login.html.twig');
    }

}