<?php

namespace WNC\SoldierBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Sonata\UserBundle\Form\Type\NameFormType;
use WNC\SoldierBundle\Form\Type\CityType;
use WNC\SoldierBundle\Entity\Soldier;

class SoldierType extends AbstractType
{
    private $_user;
    
    public function __construct($user)
    {
        $this->_user = $user;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('mothers_name')
                ->add('service_end_date', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy',
                    'attr' => array('class' => 'date six columns')
                ))
                ->add('army_unit')
                ->add('city', 'city_selector')
                ->add('gender', 'choice', array(
                    'choices' => array(0 => 'Male', 1 => 'Female'),
                    'expanded' => true,
                    'label' => 'Male / Female',
                    'data' => 0
                ))
                ->add('file', null, array(
                    'required' => false,
                    'data_class' => 'Symfony\Component\HttpFoundation\File\File'
                ))
                ->add('self_description', 'textarea', array(
                    'required' => false
                ))
                ->add('video', null, array(
                    'attr' => array(
                        'placeholder' => 'some link here',
                        'required' => false
                        )))
                ->add('wants_to_contact', null, array(
                    'label' => Soldier::getLabel('wants_to_contact')
                ))
                ->add('comments', 'textarea', array(
                    'required' => false
                ))
                ->add('user', new NameFormType('Application\Sonata\UserBundle\Entity\User'))
                ->add('city', 'city_selector')
                ->add('owner', 'entity', array(
                    'class' => 'ApplicationSonataUserBundle:User',

                    'query_builder' => function(EntityRepository $er)
                    {
                        return $er->createQueryBuilder('u')->orderBy('u.lastname', 'ASC');
                    }
                ))


        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('Soldier'),
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'wnc_soldierbundle_soldiertype';
    }

}
