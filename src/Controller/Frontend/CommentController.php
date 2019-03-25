<?php

namespace App\Controller\Frontend;

use App\Entity\Comment;
use App\Entity\CommentReports;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;


class CommentController extends AbstractController {


    /**
     * @var CommentRepository
     */
    private $repository;


    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(CommentRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/post/{id}/addComment", name="comment.add")
     */
    public function add(Post $post, Request $request)
    {

        $comment = new Comment();
        $user = $this->getUser();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($user);
            $comment->setPost($post);
            $this->em->persist($comment);
            $this->em->flush();

            return $this->redirectToRoute('post.view', array('id' =>$post->getId()) );
        }

        return $this->render('projet/Frontend/addComment.html.twig', ['Comment' => $comment, 'form' => $form->CreateView()]);

    }

    /**
     * @Route("/report/{id}/report", name="comment.report")
     */
    public function Report(Comment $comment)
    {

        $report = new CommentReports();
        $post = $comment->getPost();
        $user = $this->getUser();

        $report->setUser($user);
        $report->setComment($comment);

        $this->em->persist($report);
        $this->em->flush();

        return $this->redirectToRoute('post.view', array('id' =>$post->getId()) );


    }


}