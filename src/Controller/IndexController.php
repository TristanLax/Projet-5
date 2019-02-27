<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Common\Persistence\ObjectManager;

class IndexController extends AbstractController
{
    
    /**
     * @var PostRepository
     */
    private $repository;
    
    /** 
     * @var ObjectManager
     */
    private $em;
    
        
    public function __construct(PostRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    
    /**
     * @Route("/", name="home.index")
     */
        public function index()
    {
        $posts = $this->repository->findAll();
        return $this->render('projet/index.html.twig', ['posts' => $posts]);
    }
    
    /**
     * @Route("/post/{id}", name="post.view")
     */
        public function postView(Post $post)
    {
        $posts = $this->repository->findAll();
        return $this->render('projet/postView.html.twig', ['post' => $post]);
    }
}