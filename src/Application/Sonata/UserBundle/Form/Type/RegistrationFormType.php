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
use Symfony\Component\DependencyInjection\ContainerInterface;
class RegistrationFormType extends BaseForm {

  
  protected $container;
  protected $type;

  public function __construct(ContainerInterface $container = null)
  {
      $this->container = $container;
  }
  
  public function setType($type) 
  {
    $this->type = $type;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {

    
    $type = $this->type ? $this->type : $this->container->get('request')->get('type');
    

    if ($type == 'participant') {
      $label = 'participant';
      $form = '\WNC\SoldierBundle\Form\ParticipantType';
      $type = 'email';
    } else if($type == 'soldier') {
      $label = 'soldier';
      $form = '\WNC\SoldierBundle\Form\SoldierType';
      $type = 'hidden';
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
            ->add('email', $type, array(
                'attr' => array(
                    'placeholder' => 'Your Email'
                )))
            ->add($label, new $form($this->options));

  }

  public function getName() {
    return 'application_sonata_user_registration';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    
    $type = $this->type ? $this->type : $this->container->get('request')->get('type');
    
    $group = $type == 'participant' ? 'Participant' : 'Soldier';
    
    
    $resolver->setDefaults(array(
        'validation_groups' => array($group),
        'cascade_validation' => true,
        'data_class' => "Application\Sonata\UserBundle\Entity\User"
    ));
  }

}
