<?php

namespace App\Controller\Backend;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
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
     * @Route("/admin/comment/{id}", name="admin.comment.edit", methods="GET|POST")
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
        return $this->render('projet/Backend/commentEdit.html.twig', ['comment' => $comment, 'form' => $form->CreateView()]);
    }


    /**
     * @Route("/admin/comment/{id}", name="admin.comment.delete", methods="DELETE")
     */
    public function delete(comment $comment, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $comment->getId(), $request->get('_token') )) {
            $this->em->remove($comment);
            $this->em->flush($comment);
            $this->addFlash('success', 'Message supprimé avec succès !');
        }

        return $this->redirectToRoute('admin.index');

    }
}