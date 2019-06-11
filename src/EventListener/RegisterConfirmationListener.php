<?php

namespace App\EventListener;


use App\Event\FilterUserRegistrationEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RegisterConfirmationListener implements EventSubscriberInterface
{
    private $mailer;
    private $tokenGenerator;
    private $session;

    /**
     * EmailConfirmationListener constructor.
     *
     * @param MailerInterface         $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param SessionInterface        $session
     */
    public function __construct(MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator,  SessionInterface $session)
    {
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            "user_registration.created" => [
                ["onRegistrationSuccess", 0]
            ]
        ];
    }

    /**
     * @param FilterUserRegistrationEvent $event
     */
    public function onRegistrationSuccess(FilterUserRegistrationEvent $event)
    {
        /** @var $user \FOS\UserBundle\Model\UserInterface */
        $user = $event->getUser();

        $user->setEnabled(false);
        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }

        $this->mailer->sendConfirmationEmailMessage($user);

        $this->session->set('fos_user_send_confirmation_email/email', $user->getEmail());
        $event->stopPropagation();
    }
}
