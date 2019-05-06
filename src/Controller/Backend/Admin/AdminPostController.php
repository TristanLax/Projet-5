<?php

namespace App\Controller\Backend\Admin;

use App\Entity\Picture;
use App\Form\PostEditType;
use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class AdminPostController extends AbstractController
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
     * @Route("/admin/postModeration/{id}", name="admin.post.edit", methods="GET|POST")
     */
    public function edit(Post $post, Request $request)
    {
        $form = $this->createForm(PostEditType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Mise à jour enregistrée !');
            return $this->redirectToRoute('admin.index');
        }
        return $this->render('projet/Backend/Admin/PostModerate.html.twig', ['post' => $post, 'form' => $form->CreateView()]);
    }

    /**
     * @Route("/admin/post{id}", name="admin.picture.delete", methods="DELETE")
     */
    public function deletePicture(Picture $picture, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $picture->getId(), $request->get('_token') )) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();

            $this->addFlash('success', 'Image supprimée avec succès !');
        }
        return $this->redirectToRoute('admin.index');
    }

    /**
     * @Route("/admin/post/delete/{id}", name="admin.post.delete")
     */
    public function delete(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush();

        return new JsonResponse(['data' => []]);
    }
}
