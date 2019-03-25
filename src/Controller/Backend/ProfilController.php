<?php

namespace App\Controller\Backend;

use App\Form\PostType;
use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class ProfilController extends AbstractController
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
     * @Route("/profil", name="profil.index")
     */

    public function index()
    {
        $user = $this->getUser();
        $posts = $this->repository->findBy(['author' => $user]);
        return $this->render('projet/Backend/profil.html.twig', ['posts' => $posts, 'user' => $user]);
    }


    /**
     * @Route("/profil/post/{id}", name="profil.post.edit", methods="GET|POST")
     */

    public function edit(Post $post, Request $request)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Mise à jour enregistrée !');
            return $this->redirectToRoute('profil.index');
        }
        return $this->render('projet/Backend/edit.html.twig', ['post' => $post, 'form' => $form->CreateView()]);
    }


}