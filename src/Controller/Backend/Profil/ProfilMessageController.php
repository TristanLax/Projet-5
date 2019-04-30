<?php

namespace App\Controller\Backend\Profil;


use App\Entity\Message;
use App\Entity\User;
use App\Form\PrivateMessageType;
use App\Repository\MessageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class ProfilMessageController extends AbstractController
{


    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var MessageRepository
     */
    private $mr;


    public function __construct(MessageRepository $mr, ObjectManager $em)
    {
        $this->mr = $mr;
        $this->em = $em;
    }

    /**
     * @Route("/profil/comments", name="profil.messageIndex")
     */
    public function MessageIndex(PaginatorInterface $paginator, Request $request)
    {
        $user = $this->getUser();

        $receivedMessages = $paginator->paginate(
            $this->mr->findBy(['receiver' => $user]),
            $request->query->getInt('receivedMessage', 1),
            6,
            ['pageParameterName' => 'receivedMessage']);

        $postedMessages = $paginator->paginate(
            $this->mr->findBy(['sender' => $user]),
            $request->query->getInt('page', 1),
            3);

        return $this->render('projet/Backend/ProfilMessages.html.twig', ['received' => $receivedMessages, 'posted' => $postedMessages ,'user' => $user]);
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