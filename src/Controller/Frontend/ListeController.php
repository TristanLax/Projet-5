<?php

namespace App\Controller\Frontend;


use App\Form\PrivateMessageType;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Message;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListeController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(UserRepository $userRepository, ObjectManager $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Route("/userlist", name="liste.index")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $users = $paginator->paginate(
            $this->userRepository->findAll(),
            $request->query->getInt('page', 1),
            6);

        return $this->render('projet/Frontend/userList.html.twig', ['users' => $users]);
    }

    /**
     * @Route ("profil/private/{id}", name="private.message")
     */
    public function privateMessage(User $user, Request $request)
    {
        $message = new Message();
        $sender = $this->getUser();
        $receiver = $user;

        $form = $this->createForm(PrivateMessageType::class, $message);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $message->setSender($sender);
            $message->setReceiver($receiver);
            $this->em->persist($message);
            $this->em->flush();
            return $this->redirectToRoute('liste.index');
        }

        return $this->render("projet/Frontend/PrivateMessage.html.twig", ['form' => $form->CreateView()]);

    }
}