<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\SecurityBundle\Security;

class BlockedUserSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private UrlGeneratorInterface $urlGenerator
    ) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        // Only inspect main requests (skip sub-requests/fragments)
        if (!$event->isMainRequest()) {
            return;
        }

        /** @var User|null $user */
        $user = $this->security->getUser();

        // If no user is logged in or user is active, do nothing
        if (!$user || !$user->isBlocked()) {
            return;
        }

        $currentRoute = $event->getRequest()->attributes->get('_route');

        // Allow access only to the blocked page and logout route
        $allowedRoutes = ['app_blocked_user', 'app_logout'];

        if (!in_array($currentRoute, $allowedRoutes, true)) {
            $response = new RedirectResponse($this->urlGenerator->generate('app_blocked_user'));
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 1],
        ];
    }
}
