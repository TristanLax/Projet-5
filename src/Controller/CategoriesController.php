<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoriesController extends AbstractController
{
    
    /**
     * @Route("/categories", name="categories.index")
     */
        public function index()
    {
        return $this->render('projet/categories.html.twig');
    }

}