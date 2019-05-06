<?php

namespace App\Controller\Frontend;


use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FrontProfilController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var PostRepository
     */
    private $repository;


    /**
     * @var CommentRepository
     */
    private $cr;


    public function __construct(PostRepository $repository, CommentRepository $cr, UserRepository $userRepository, ObjectManager $em)
    {
        $this->userRepository = $userRepository;
        $this->repository = $repository;
        $this->cr = $cr;
        $this->em = $em;
    }


    /**
     * @Route("/userlist", name="liste.index")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $users = $paginator->paginate(
            $this->userRepository->findAll(),
            $request->query->getInt('page', 1),
            6);

        return $this->render('projet/Frontend/userList.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/memberProfil/{id}", name="public.profil.index")
     */
    public function profilIndex(User $user)
    {
        $numberComments = $this->cr->countComments($user);
        $numberPosts = $this->repository->countPosts($user);

        return $this->render('projet/Frontend/PublicProfil.html.twig', ['user' => $user, 'comments' => $numberComments, 'posts' => $numberPosts]);
    }
}
