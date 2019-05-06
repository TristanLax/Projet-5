<?php

namespace App\Controller\Backend\Profil;


use App\Form\ResetPasswordType;
use App\Form\UserAvatarType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder, ObjectManager $em)
    {
        $this->encoder = $encoder;
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
        return $this->render('projet/Backend/Profil/IndexProfil.html.twig', ['user' => $user, 'form' => $form->CreateView()]);
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
        return $this->render('projet/Backend/Profil/PasswordReset.html.twig', ['user' => $user, 'form' => $form->CreateView()]);
    }
}
