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
        $main = $this->createMenuItem($dm, $root, 'main', array('en' => 'Home', 'il' => 'דף הבית'), null, null, 'homepage');
        $main->setChildrenAttributes(array("class" => "sub-nav"));



        $mission = $this->createMenuItem($dm, $main, 'mission-item', array('en' => 'Mission', 'il' => 'רטמ'), $dm->find(null, "$content_path/mission"));
        $about = $this->createMenuItem($dm, $main, 'about-item', array('en' => 'About', 'il' => 'ונחנא ימ'), $dm->find(null, "$content_path/about"));
        $faq = $this->createMenuItem($dm, $main, 'faq-item', array('en' => 'FAQ', 'il' => 'ונחנא ימ'), null, null, 'evercode_faq_faq_faq');
        $press = $this->createMenuItem($dm, $main, 'press-item', array('en' => 'Press', 'il' => 'רשק רו'), null, null, 'sonata_news_news');
        $contact = $this->createMenuItem($dm, $main, 'contact-item', array('en' => 'Contact', 'il' => 'רשק רו'), null, null, 'cmf_routing_dynamic_route_cms_routes_en_contact');
        $donate = $this->createMenuItem($dm, $main, 'donate-item', array('en' => 'Donate', 'il' =>'וישכע םורת'), $dm->find(null, "$content_path/donate"));
        $register = $this->createMenuItem($dm, $main, 'register_button', array('en' => 'Signup', 'il' =>'המשרה'), null, null, 'fos_user_registration_ajax');
        $privacy = $this->createMenuItem($dm, $main, 'privacy-item', array('en' => 'Privacy Policy', 'il' =>'המשרה'), $dm->find(null, "$content_path/privacy"));
        

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
