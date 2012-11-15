<?php
namespace WNC\SoldierBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RequestContextAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Initializes the locale based on the current request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class LocaleListener implements EventSubscriberInterface
{
    private $router;
    private $defaultLocale;
    private $session;

    public function __construct($defaultLocale = 'en',  Session $session, RequestContextAwareInterface $router = null)
    {
        $this->defaultLocale = $defaultLocale;
        $this->session = $session;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        
        $request->setDefaultLocale($this->session->get('_locale', $this->defaultLocale));

        if ($locale = $request->attributes->get('_locale')) {
            $request->setLocale($locale);
            $this->session->set('_locale', $locale);
        }

    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the Router to have access to the _locale
            KernelEvents::REQUEST => array(array('onKernelRequest', 14)),
        );
    }
}