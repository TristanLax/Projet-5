<?php

namespace App\Controller\Backend\Profil;

use App\Entity\Picture;
use App\Form\PostEditType;
use App\Form\PostType;
use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class ProfilPostController extends AbstractController
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
     * @Route("/profil/sujets", name="profil.postIndex")
     */
    public function postIndex(PaginatorInterface $paginator, Request $request)
    {
        $user = $this->getUser();

        $posts = $paginator->paginate(
            $this->repository->findBy(['author' => $user]),
            $request->query->getInt('page', 1),
            12);

        return $this->render('projet/Backend/ProfilPost.html.twig', ['posts' => $posts,'user' => $user]);

    }


    /**
     * @Route("/profil/post/create", name="user.post.add")
     */
    public function addPost(Request $request)
    {
        $post = new Post();
        $user = $this->getUser();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post->setAuthor($user);
            $this->em->persist($post);
            $this->em->flush();
            $this->addFlash('success', 'Nouveau post crée !');

            return $this->redirectToRoute('profil.postIndex');
        }

        return $this->render('projet/Backend/add.html.twig', ['Post' => $post, 'form' => $form->CreateView()]);
    }


    /**
     * @Route("/profil/post/{id}", name="profil.post.edit", methods="GET|POST")
     */
    public function editPost(Post $post, Request $request)
    {
        $form = $this->createForm(PostEditType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Mise à jour enregistrée !');
            return $this->redirectToRoute('profil.postIndex');
        }
        return $this->render('projet/Backend/edit.html.twig', ['post' => $post, 'form' => $form->CreateView()]);
    }

    /**
     * @Route("/profil/post{id}", name="profil.picture.delete", methods="DELETE")
     */
    public function postPictureDelete(Picture $picture, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $picture->getId(), $request->get('_token') )) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush($picture);

            $this->addFlash('success', 'Image supprimée avec succès !');
        }

        return $this->redirectToRoute('profil.postIndex');
    }



}