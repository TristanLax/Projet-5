<?php

namespace App\Controller\Frontend;

use App\Entity\Post;
use App\Entity\PostReports;
use App\Entity\PostVotes;
use App\Repository\CommentReportsRepository;
use App\Repository\CommentRepository;
use App\Repository\PostReportsRepository;
use App\Repository\PostVotesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FrontPostController extends AbstractController
{

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
     * @var PostReportsRepository
     */
    private $prr;

    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(CommentRepository $commentRepository, PostVotesRepository $vr, CommentReportsRepository $rr, PostReportsRepository $prr,  ObjectManager $em)
    {
        $this->commentRepository = $commentRepository;
        $this->vr = $vr;
        $this->rr = $rr;
        $this->prr = $prr;
        $this->em = $em;
    }


    /**
     * @Route("/post/{id}", name="post.view")
     */
    public function postView(Post $post)
    {
        $isSignaled = [];
        $user = $this->getUser();

        $vote = $this->vr->findOneBy([
            'user' => $user,
            'post' => $post,
        ]);

        $postReport = $this->prr->findOneBy([
            'user' => $user,
            'post' => $post,
        ]);

        $comments = $this->commentRepository->findBy([
            'post' => $post
        ]);

        $userComments = $this->commentRepository->findBy([
            'post' => $post,
            'author' => $user
        ]);

        $reports = $this->rr->findBy([
            'comment' => $comments,
            'user' => $user,
        ]);

        foreach($reports as $report) {
            $isSignaled[] = $report->getComment()->getId();
        }

        return $this->render('projet/Frontend/postView.html.twig', ['post' => $post, 'comments' => $comments, 'userComments' => $userComments, 'vote' => $vote, 'postReport' => $postReport, 'signalements' => $isSignaled]);
    }

    /**
     * @Route("post/{id}/report", name="post.report")
     */
    public function Report(Post $post)
    {
        $report = new PostReports();
        $user = $this->getUser();

        $report->setUser($user);
        $report->setPost($post);

        $this->em->persist($report);
        $this->em->flush();

        return new JsonResponse(['data' => []]);
    }

    /**
     * @Route("post/{id}/removeReport", name="post.report.remove")
     */
    public function removeReport(Post $post)
    {
        $user = $this->getUser();

        $report = $this->prr->findOneBy([
            'user' => $user,
            'post' => $post,
        ]);

        $this->em->remove($report);
        $this->em->flush();

        return new JsonResponse(['data' => []]);
    }

    /**
     * @Route("post/{id}/vote", name="post.vote")
     */
    public function Vote(Post $post)
    {
        $vote = new PostVotes();
        $user = $this->getUser();

        $vote->setUser($user);
        $vote->setPost($post);

        $this->em->persist($vote);
        $this->em->flush();

        return new JsonResponse(['data' => []]);
    }

    /**
     * @Route("post/{id}/unvote", name="post.unvote")
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

        return new JsonResponse(['data' => []]);
    }
}
