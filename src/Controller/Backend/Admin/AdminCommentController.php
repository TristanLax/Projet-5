<?php

namespace App\Controller\Backend\Admin;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/admin/commentModeration/{id}", name="admin.comment.edit", methods="GET|POST")
     */
    public function edit(comment $comment, Request $request)
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Mise à jour enregistrée !');
            return $this->redirectToRoute('admin.index');
        }
        return $this->render('projet/Backend/Admin/CommentModerate.html.twig', ['comment' => $comment, 'form' => $form->CreateView()]);
    }

    /**
     * @Route("/admin/comment/delete/{id}", name="admin.comment.delete")
     */
    public function delete(comment $comment)
    {
        $this->em->remove($comment);
        $this->em->flush();

        return new JsonResponse(['data' => []]);
    }
}
