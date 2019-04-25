<?php

namespace App\Controller\Backend;

use App\Form\PostType;
use App\Entity\Post;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @var CommentRepository
     */
    private $cr;

    /**
     * @var ObjectManager
     */
    private $em;
    
    
    public function __construct(PostRepository $repository, ObjectManager $em, CommentRepository $cr)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->cr = $cr;
    }
    
    /**
     * @Route("/admin", name="admin.index")
     */
    
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $reportedComments = $paginator->paginate(
            $this->cr->countReports(),
            $request->query->getInt('reportedComments', 1),
            6,
            ['pageParameterName' => 'reportedComments']);


        $user = $this->getUser();

        $reportedPosts = $paginator->paginate(
            $this->repository->countReports(),
            $request->query->getInt('page', 1),
            6);

        $comments = $this->cr->findAll();


        return $this->render('projet/Backend/admin.html.twig', ['reportedPosts' => $reportedPosts, 'comments' => $comments ,'user' => $user, 'reportedComments' => $reportedComments]);

    }

    /**
     * @Route("/profil/post/create", name="user.post.add")
     */

    public function add(Request $request)
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

            return $this->redirectToRoute('profil.index');
        }

        return $this->render('projet/Backend/add.html.twig', ['Post' => $post, 'form' => $form->CreateView()]);
    }

    /**
     * @Route("/admin/post/{id}", name="admin.post.edit", methods="GET|POST")
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
        return $this->render('projet/Backend/edit.html.twig', ['post' => $post, 'form' => $form->CreateView()]);
    }
    
    
    /**
     * @Route("/admin/post/delete/{id}", name="admin.post.delete")
     */
    public function delete(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush($post);

        return new JsonResponse(['data' => []]);

    }

}