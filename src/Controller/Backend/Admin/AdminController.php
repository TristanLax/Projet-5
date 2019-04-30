<?php

namespace App\Controller\Backend\Admin;

use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class AdminController extends AbstractController
{

    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * @var CommentRepository
     */
    private $cr;

    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(PostRepository $repository, ObjectManager $em, CommentRepository $cr)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->cr = $cr;
    }


    /**
     * @Route("/admin", name="admin.index")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $user = $this->getUser();

        $reportedComments = $paginator->paginate(
            $this->cr->countReports(),
            $request->query->getInt('reportedComments', 1),
            6,
            ['pageParameterName' => 'reportedComments']);

        $reportedPosts = $paginator->paginate(
            $this->repository->countReports(),
            $request->query->getInt('page', 1),
            6);

        return $this->render('projet/Backend/admin.html.twig', ['user' => $user, 'reportedPosts' => $reportedPosts, 'reportedComments' => $reportedComments]);
    }

}