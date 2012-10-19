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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('mothers_name',null, array('attr' => array('placeholder' => 'Mother\'s name')))
                ->add('service_end_date', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy',
                    'attr' => array('class' => 'date six columns')
                ))
                ->add('army_unit')
                ->add('city', 'city_selector')
                ->add('gender', 'choice', array(
                    'choices' => array('male' => 'Male', 'female' => 'Female'),
                    'expanded' => true,
                    'label' => 'Male / Female',
                ))
                ->add('file', 'file', array(
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
                ->add('wants_to_contact', 'checkbox', array(
                    'label' => Soldier::getLabel('wants_to_contact')
                ))
                ->add('comments', 'textarea', array(
                    'required' => false
                ))
//                ->add('user', new NameFormType('Application\Sonata\UserBundle\Entity\User'))
                ->add('city', 'city_selector', array('attr' => array('placeholder' => 'City name')))


        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('Soldier'),
            'cascade_validation' => true,
            'data_class' => "WNC\SoldierBundle\Entity\Soldier"
        ));
    }

    public function getName()
    {
        return 'wnc_soldierbundle_soldiertype';
    }

}
