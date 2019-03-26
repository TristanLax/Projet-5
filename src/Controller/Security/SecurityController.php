<?php

namespace App\Controller\Security;

use App\Form\UserType;
use App\Entity\User;
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


    public function __construct(ObjectManager $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
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
    public function newUser(Request $request, \Swift_Mailer $mailer)
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

                $mail = (new \Swift_Message('Email de bienvenue'))
                    ->setFrom('Tanamassar@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'projet/Security/email.html.twig',
                        ['pseudo' => $user->getUsername()]
                        ),
                        'text/html'
                    );

                $mailer->send($mail);

            }

            return $this->render('projet/Security/create.html.twig', ['User' => $user, 'form' => $form->CreateView()]);

        }
    }

}