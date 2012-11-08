<?php

namespace Application\Sonata\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use WNC\SoldierBundle\Entity\Soldier;
use WNC\SoldierBundle\Entity\Participant;
use WNC\SoldierBundle\Form\SoldierType;
use WNC\SoldierBundle\Form\ParticipantType;
class RegistrationController extends BaseController
{
  
    public function ajaxAction()
    {
        $participant = new Participant();
        $soldier = new Soldier();
        
        $f = new \Application\Sonata\UserBundle\Form\Type\RegistrationFormType();
        $f2 = new \Application\Sonata\UserBundle\Form\Type\RegistrationFormType();
        
        $f->setType('participant');
        $f2->setType('soldier');
        
        $form2   = $this->container->get('form.factory')->create($f2);
        $form   = $this->container->get('form.factory')->create($f);
      
        return $this->container->get('templating')->renderResponse('ApplicationSonataUserBundle:User:ajax.html.'.$this->getEngine(), array(
            'form2'   => $form->createView(),
            'form'   => $form2->createView(),
        ));

    }
    
    public function otherAction()
    {
        return $this->container->get('templating')->renderResponse('ApplicationSonataUserBundle:User:other.html.'.$this->getEngine(), array(
        ));
    }
  
    public function registerAction()
    {
        
        $request = $this->container->get('request');
      
        $type = $request->get('type');
       
        
        
        $fromHomepage = $request->getUri() != $request->headers->get('referer');
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        
        
        $process = $formHandler->process($confirmationEnabled);
        
        if ($process) {
            $user = $form->getData();
            
            $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
            $route = 'fos_user_registration_check_email';

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            return $response;
        }
        else if($fromHomepage) {
          
          
            $form = $this->container->get('form.factory')->createNamed($form->getName(), 
                    new \Application\Sonata\UserBundle\Form\Type\RegistrationFormType($this->container), 
                    $form->getData());
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
            'type' => $request->get('type')
        ));
      
    }
}
