<?php

namespace App\Controller\Backend;

use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class PictureController extends AbstractController {

    /**
     * @Route("/admin{id}", name="admin.picture.delete", methods="DELETE")
     */
    public function delete(Picture $picture, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $picture->getId(), $request->get('_token') )) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush($picture);

            $this->addFlash('success', 'Image supprimée avec succès !');
        }

        return $this->redirectToRoute('admin.index');
    }


}