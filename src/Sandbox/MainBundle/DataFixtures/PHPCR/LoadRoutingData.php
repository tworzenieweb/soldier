<?php

namespace Sandbox\MainBundle\DataFixtures\PHPCR;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use PHPCR\Util\NodeHelper;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route;
use Symfony\Cmf\Bundle\RoutingExtraBundle\Document\RedirectRoute;

class LoadRoutingData extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 21;
    }

    /**
     * Load routing data into the document manager.
     *
     * NOTE: We demo all possibilities. Of course, you should try to be
     * consistent in what you use and only use different things for special
     * cases.
     *
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     */
    public function load(ObjectManager $dm)
    {
        $session = $dm->getPhpcrSession();

        $basepath = $this->container->getParameter('symfony_cmf_routing_extra.routing_repositoryroot');
        $content_path = $this->container->getParameter('symfony_cmf_content.content_basepath');

        if ($session->itemExists($basepath)) {
            $session->removeItem($basepath);
        }

        NodeHelper::createPath($session, $basepath);
        $parent = $dm->find(null, $basepath);

        $locales = $this->container->getParameter('locales');
        foreach ($locales as $locale) {
            
            $home = new Route;
            $home->setPosition($parent, $locale);
            $home->setDefault(RouteObjectInterface::TEMPLATE_NAME, 'SandboxMainBundle:Homepage:index.html.twig');
            $home->setRouteContent($dm->find(null, "$content_path/home"));
            $dm->persist($home);

            $mission = new Route;
            $mission->setPosition($home, 'mission');
            $mission->setRouteContent($dm->find(null, "$content_path/mission"));
            $dm->persist($mission);
            
            $about = new Route;
            $about->setPosition($home, 'about');
            $about->setRouteContent($dm->find(null, "$content_path/about"));
            $dm->persist($about);
            
            $contact = new Route;
            $contact->setPosition($home, 'contact');
            $contact->setRouteContent($dm->find(null, "$content_path/contact"));
            $contact->setDefault(RouteObjectInterface::CONTROLLER_NAME, 'WNCSoldierBundle:Default:contact');
            
            $dm->persist($contact);

            
            
            $donate = new Route;
            $donate->setPosition($home, 'donate');
            $donate->setRouteContent($dm->find(null, "$content_path/donate"));
            $dm->persist($donate);

        }

        
        $dm->flush();
    }
}
