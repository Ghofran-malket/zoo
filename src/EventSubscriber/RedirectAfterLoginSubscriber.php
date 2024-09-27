<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class RedirectAfterLoginSubscriber implements EventSubscriberInterface
{
    private $router;
    private $session;

    public function __construct(RouterInterface $router, SessionInterface $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            InteractiveLoginEvent::class => 'onLoginSuccess',
        ];
    }


    public function onLoginSuccess(InteractiveLoginEvent $event)
    {
         // Get the authenticated user
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();

        // Check user roles and set redirect URL in the session
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $this->session->set('redirect_after_login', $this->router->generate('app_admin'));
        } elseif (in_array('ROLE_VETERINARY', $user->getRoles())) {
            $this->session->set('redirect_after_login', $this->router->generate('app_veterinaire'));
        } elseif (in_array('ROLE_EMPLOYEE', $user->getRoles())) {
            $this->session->set('redirect_after_login', $this->router->generate('app_employee'));
        } else {
            $this->session->set('redirect_after_login', $this->router->generate('app_home'));
        }
    }

}
