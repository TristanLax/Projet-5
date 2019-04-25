<?php

namespace App\Service;


class Email
{


    private $templating;
    private $mailer;


    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }


    public function SendMail($user)
    {

        $mail = (new \Swift_Message('Email de bienvenue'))
            ->setFrom('Tanamassar@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render('projet/Security/email.html.twig', ['pseudo' => $user->getUsername()]
                ),
                'text/html'
            );

        return $this->mailer->send($mail);

    }
}