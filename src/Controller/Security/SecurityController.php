<?php

namespace App\Controller\Security;

use App\Form\UserType;
use App\Entity\User;
use App\Service\Email;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController{


    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var Email
     */
    private $email;


    public function __construct(ObjectManager $em, UserPasswordEncoderInterface $encoder, Email $email)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->email = $email;
    }

    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('projet/Security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/create", name="create.account")
     */
    public function newUser(Request $request)
    {
        {
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $password = $this->encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $this->em->persist($user);
                $this->em->flush();
                $this->email->SendMail($user);

                return $this->redirectToRoute('login');

            }

            return $this->render('projet/Security/create.html.twig', ['User' => $user, 'form' => $form->CreateView()]);

        }
    }

}