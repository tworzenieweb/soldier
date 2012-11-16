<?php

namespace WNC\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WNC\FaqBundle\Entity\Faq;
use Evercode\Bundle\FaqBundle\Controller\FaqController as BaseController;


class FaqController extends BaseController
{
    /**
     * @Route("/faq")
     * @Template()
     */
    public function faqAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->getRepository('WNCFaqBundle:Faq')->findBy(array(
            'locale' => $this->getRequest()->getLocale()
        ));

        return array(
            'query' => $query,
        );
    }
}
