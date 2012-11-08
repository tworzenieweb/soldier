<?php

namespace Sandbox\MainBundle\DataFixtures\PHPCR;

use Doctrine\Common\DataFixtures\FixtureInterface;
use PHPCR\RepositoryInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use PHPCR\Util\NodeHelper;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Cmf\Bundle\MenuBundle\Document\MenuItem;
use Symfony\Cmf\Bundle\MenuBundle\Document\MultilangMenuItem;

class LoadMenuData extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 10;
    }

    /**
     * @param \Doctrine\ODM\PHPCR\DocumentManager $dm
     */
    public function load(ObjectManager $dm)
    {
        $session = $dm->getPhpcrSession();

        $basepath = $this->container->getParameter('symfony_cmf_menu.menu_basepath');
        $content_path = $this->container->getParameter('symfony_cmf_content.content_basepath');

        NodeHelper::createPath($session, $basepath);
        $root = $dm->find(null, $basepath);

        /** @var $menuitem MenuItem */
        $main = $this->createMenuItem($dm, $root, 'main', 'homepage', null, null, 'homepage');
        $main->setChildrenAttributes(array("class" => "menu_main"));


        $this->createMenuItem($dm, $main, 'about', 'About', $dm->find(null, "$content_path/about"));
        $this->createMenuItem($dm, $main, 'mission', 'Mission', $dm->find(null, "$content_path/mission"));
        $this->createMenuItem($dm, $main, 'faq', 'FAQ', null, null, 'evercode_faq_faq_faq');
        $this->createMenuItem($dm, $main, 'press', 'Press', null, null, 'sonata_news_news');
        $this->createMenuItem($dm, $main, 'contact', 'Contact', $dm->find(null, "$content_path/contact"));
        $this->createMenuItem($dm, $main, 'contact', 'Donate', $dm->find(null, "$content_path/donate"));
        $this->createMenuItem($dm, $main, 'signup', 'Signup', null, null, 'fos_user_registration_ajax');



        $dm->flush();
    }

    /**
     * @return a Navigation instance with the specified information
     */
    protected function createMenuItem($dm, $parent, $name, $label, $content, $uri = null, $route = null)
    {
        $menuitem = is_array($label) ? new MultilangMenuItem() : new MenuItem();
        $menuitem->setParent($parent);
        $menuitem->setName($name);

        $dm->persist($menuitem); // do persist before binding translation

        if (null !== $content) {
            $menuitem->setContent($content);
        } else if (null !== $uri) {
            $menuitem->setUri($uri);
        } else if (null !== $route) {
            $menuitem->setRoute($route);
        }

        if (is_array($label)) {
            foreach ($label as $locale => $l) {
                $menuitem->setLabel($l);
                $dm->bindTranslation($menuitem, $locale);
            }
        } else {
            $menuitem->setLabel($label);
        }

        return $menuitem;
    }
}
