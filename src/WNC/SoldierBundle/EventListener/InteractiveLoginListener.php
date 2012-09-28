<?php

namespace WNC\SoldierBundle\EventListener;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class InteractiveLoginListener
{
    /**
     * @var \Symfony\Component\Routing\Router
     */
    private $router;

    /**
     * @param \Symfony\Component\Routing\Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser(); /** @var \Application\Sonata\UserBundle\Entity\User */
        $request = $event->getRequest(); /** @var \Symfony\Component\HttpFoundation\Request $request  */

//        if ($user instanceof User) {
//            $request->request->set('_target_path', $this->router->generate('soldier'));
//        }
    }
}