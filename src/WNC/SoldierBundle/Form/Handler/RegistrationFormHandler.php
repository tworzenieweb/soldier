<?php

namespace WNC\SoldierBundle\Form\Handler;
use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;

class RegistrationFormHandler extends BaseHandler
{
    protected function onSuccess(UserInterface $user, $confirmation)
    {
        // Note: if you plan on modifying the user then do it before calling the 
        // parent method as the parent method will flush the changes
        $user->setUsername($user->getEmail());
        $user->setPlainPassword(substr(uniqid(), 0,8));
        parent::onSuccess($user, $confirmation);
        
    }
}
