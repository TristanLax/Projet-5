<?php

namespace App\Controller\Backend\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class AdminProfilController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(UserRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/banUser/{id}", name="admin.banUser")
     */
    public function banUser(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();

        return new JsonResponse(['data' => []]);
    }

}