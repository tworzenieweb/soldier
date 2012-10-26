<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType as BaseForm;
use  Symfony\Component\Security\Core\SecurityContext;

class EditFormType extends BaseForm {

  
  
  private $context;

  public function __construct(SecurityContext $context)
  {
      $this->context = $context;
  }

  public function getUser()
  {
      return $this->context->getToken()->getUser();
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {

    

    if ($this->getUser()->getType() == 'participant') {
      $label = 'participant';
      $form = '\WNC\SoldierBundle\Form\ParticipantType';
    } else if($this->getUser()->getType() == 'soldier') {
      $label = 'soldier';
      $form = '\WNC\SoldierBundle\Form\SoldierType';
    }


    $builder->add('firstname', null, array(
                'label' => 'First Name',
                'attr' => array(
                    'placeholder' => 'Your first name'
                    )))
            ->add('lastname', null, array(
                'label' => 'Last Name',
                'attr' => array(
                    'placeholder' => 'Your lastname'
                    )))
            ->add('plainPassword', 'hidden', array(
                'data' => substr(uniqid(), 0, 8),
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'Your Email'
                ),
                'label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add($label, new $form($this->options));

  }

  public function getName() {
    return 'application_sonata_user_edit';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'validation_groups' => array('Soldier'),
        'cascade_validation' => true,
        'data_class' => "Application\Sonata\UserBundle\Entity\User"
    ));
  }

}
