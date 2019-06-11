<?php

namespace App\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;


class PasswordResettingListener implements EventSubscriberInterface
{

    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::RESETTING_RESET_SUCCESS  => ['onPasswordResettingSuccess'],
            FOSUserEvents::REGISTRATION_SUCCESS => [
                ['onRegistrationSuccess', -10],
            ]
        );
    }

    public function onPasswordResettingSuccess(FormEvent $event)
    {

        $event->setResponse(new RedirectResponse($this->router->generate('redirectTo')));
    }
}
