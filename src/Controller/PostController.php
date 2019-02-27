<?php

namespace App\Controller;

use App\Form\PostType;
use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class PostController extends AbstractController
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
     * @Route("/admin", name="admin.index")
     */
    
    public function index()
    {
        $posts = $this->repository->findAll();
        return $this->render('projet/admin.html.twig', ['posts' => $posts]);
        
    }
    
    
    /**
     * @Route("/create", name="post.add")
     */
    
    public function add(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        
            if($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($post);
                $this->em->flush();
                $this->addFlash('success', 'Nouveau post crée !');
                
                return $this->redirectToRoute('admin.index');
            }
        
        return $this->render('projet/add.html.twig', ['Post' => $post, 'form' => $form->CreateView()]);
    }
    
    
    /**
     * @Route("/admin/{id}", name="admin.post.edit", methods="GET|POST")
     */
    
    public function edit(Post $post, Request $request) 
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        
            if($form->isSubmitted() && $form->isValid()) {
                $this->em->flush();
                $this->addFlash('success', 'Mise à jour enregistrée !');
                return $this->redirectToRoute('admin.index');
            }
        return $this->render('projet/edit.html.twig', ['Post' => $post, 'form' => $form->CreateView()]);
    }
    
    
    /**
     * @Route("/admin/{id}", name="admin.post.delete", methods="DELETE")
     */
    public function delete(Post $post, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $post->getId(), $request->get('_token') )) {
        $this->em->remove($post);
        $this->em->flush();
            $this->addFlash('success', 'Message supprimé avec succès !');
        }
        
        return $this->redirectToRoute('admin.index');
    }

}