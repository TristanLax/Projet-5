<?php

namespace App\Controller\Frontend;

use App\Entity\CommentReports;
use App\Entity\PostVotes;
use App\Repository\CommentReportsRepository;
use App\Repository\CommentRepository;
use App\Repository\PostVotesRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
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
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var PostVotesRepository
     */
    private $vr;

    /**
     * @var CommentReportsRepository
     */
    private $rr;
    
    /** 
     * @var ObjectManager
     */
    private $em;
    
        
    public function __construct(PostRepository $repository, CommentRepository $commentRepository, PostVotesRepository $vr, CommentReportsRepository $rr,  ObjectManager $em)
    {
        $this->repository = $repository;
        $this->commentRepository = $commentRepository;
        $this->vr = $vr;
        $this->rr = $rr;
        $this->em = $em;
    }
    
    
    /**
     * @Route("/", name="home.index")
     */
        public function index(PaginatorInterface $paginator, Request $request)
    {
        $posts = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1),
            6);
        return $this->render('projet/Frontend/index.html.twig', ['posts' => $posts]);
    }
    
    /**
     * @Route("/post/{id}", name="post.view")
     */
        public function postView(Post $post)
    {
        $user = $this->getUser();
        $vote = $this->vr->findOneBy([
            'user' => $user,
            'post' => $post,
        ]);

        $comments = $this->commentRepository->findBy([
            'post' => $post
        ]);

        $report = $this->rr->findBy([
            'comment' => $comments,
            'user' => $user,
        ]);

        return $this->render('projet/Frontend/postView.html.twig', ['post' => $post, 'vote' => $vote, 'report' => $report]);
    }

    /**
     * @Route("/post/{id}/vote", name="post.vote")
     */
        public function Vote(Post $post)
        {

            $vote = new PostVotes();
            $user = $this->getUser();

            $vote->setUser($user);
            $vote->setPost($post);

            $this->em->persist($vote);
            $this->em->flush();

            return $this->redirectToRoute('post.view', array('id' =>$post->getId()) );


        }

    /**
     * @Route("/post/{id}/unvote", name="post.unvote")
     */
    public function Unvote(Post $post)
    {

        $user = $this->getUser();

        $vote = $this->vr->findOneBy([
            'user' => $user,
            'post' => $post,
        ]);

        $this->em->remove($vote);
        $this->em->flush();

        return $this->redirectToRoute('post.view', array('id' =>$post->getId()) );


    }
}