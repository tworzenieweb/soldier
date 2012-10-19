<?php

namespace WNC\SoldierBundle\Form\Handler;
use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;

class RegistrationFormHandler extends BaseHandler
{
    
    public function process($confirmation = false)
    {
        // when we get from homepage initial validation should not be triggered
        $fromHomepage = $this->request->getUri() != $this->request->headers->get('referer');
        
        
      
        $user = $this->createUser();
        $this->form->setData($user);

        $type = $this->request->get('type');
        
        if ('POST' === $this->request->getMethod()) {
            
          
            $this->form->bindRequest($this->request);

            
            if (!$fromHomepage && $this->form->isValid()) {
              
                $user->addRole($type);
              
                $this->onSuccess($user, $confirmation);

                return true;
            }
        }

        return false;
    }
}
