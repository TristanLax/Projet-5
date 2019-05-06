<?php

namespace App\Controller\Frontend;


use App\Repository\PostVotesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PostRepository;

class IndexController extends AbstractController
{
    
    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * @var PostVotesRepository
     */
    private $vr;

    /**
     * @var ObjectManager
     */
    private $em;

        
    public function __construct(PostRepository $repository, PostVotesRepository $vr, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->vr = $vr;
        $this->em = $em;
    }
    
    
    /**
     * @Route("/", name="home.index")
     */
        public function index(PaginatorInterface $paginator, Request $request)
    {
        $bestVotes = $this->repository->countVotes();
        $posts = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1),
            6);

        return $this->render('projet/Frontend/index.html.twig', ['posts' => $posts, 'votedPosts' => $bestVotes]);
    }
}
