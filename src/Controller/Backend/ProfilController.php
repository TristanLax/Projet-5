<?php

namespace App\Controller\Backend;

use App\Form\PostType;
use App\Entity\Post;
use App\Form\ResetPasswordType;
use App\Form\UserAvatarType;
use App\Repository\CommentRepository;
use App\Repository\MessageRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{

    /**
     * @var PostRepository
     */
    private $repository;


    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var CommentRepository
     */
    private $cr;

    /**
     * @var MessageRepository
     */
    private $mr;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;


    public function __construct(PostRepository $repository, CommentRepository $cr, MessageRepository $mr, UserPasswordEncoderInterface $encoder, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
        $this->cr = $cr;
        $this->mr = $mr;
        $this->em = $em;
    }

    /**
     * @Route("/profil", name="profil.index")
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserAvatarType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->render('projet/Backend/profil.html.twig', ['user' => $user, 'form' => $form->CreateView()]);
    }

    /**
     * @Route("/profil/sujets", name="profil.postIndex")
     */
    public function postIndex(PaginatorInterface $paginator, Request $request)
    {
        $user = $this->getUser();

        $posts = $paginator->paginate(
            $this->repository->findBy(['author' => $user]),
            $request->query->getInt('page', 1),
            12);

        return $this->render('projet/Backend/ProfilPost.html.twig', ['posts' => $posts,'user' => $user]);

    }

    /**
     * @Route("/profil/comments", name="profil.messageIndex")
     */
    public function privateMessageIndex()
    {
        $user = $this->getUser();
        $receivedMessages = $this->mr->findBy(['receiver' => $user]);
        $postedMessages = $this->mr->findBy(['sender' => $user]);
        return $this->render('projet/Backend/ProfilMessages.html.twig', ['received' => $receivedMessages, 'posted' => $postedMessages ,'user' => $user]);

    }

    /**
     * @Route("/profil/passwordChange", name="profil.passwordEdit")
     */
    public function passwordEdit(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $request->get('reset_password')['oldPassword'];
            $checkPass = $this->encoder->isPasswordValid($user, $oldPassword);



            if($checkPass === true) {
                $newPassword = $this->encoder->encodePassword($user, $form->get('password')->getData());
                $user->setPassword($newPassword);
                $this->em->persist($user);
                $this->em->flush();
            }

        }

        return $this->render('projet/Backend/profilPassword.html.twig', ['user' => $user, 'form' => $form->CreateView()]);

    }




    /**
     * @Route("/profil/post/{id}", name="profil.post.edit", methods="GET|POST")
     */

    public function edit(Post $post, Request $request)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Mise à jour enregistrée !');
            return $this->redirectToRoute('profil.index');
        }
        return $this->render('projet/Backend/edit.html.twig', ['post' => $post, 'form' => $form->CreateView()]);
    }


}