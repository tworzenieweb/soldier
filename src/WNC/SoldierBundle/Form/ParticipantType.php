<?php

namespace WNC\SoldierBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Sonata\UserBundle\Form\Type\NameFormType;
use WNC\SoldierBundle\Form\Type\CityType;
use WNC\SoldierBundle\Entity\Participant;

class ParticipantType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('city', 'city_selector')
                ->add('gender', 'choice', array(
                    'choices' => array(0 => 'Male', 1 => 'Female'),
                    'expanded' => true,
                    'label' => 'Male / Female',
                    'data' => 0
                ))
                ->add('picture', 'sonata_media_type', array(
                    'required' => false,
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'user',
                    'label' => 'Picture'
                ))
                ->add('birth_date', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'MM-dd-yyyy',
                    'attr' => array('class' => 'date six columns')
                ))
                ->add('activity', 'entity', array(
                    'class' => 'WNCSoldierBundle:Activity',
                    'property' => 'name',
                    'empty_value' => 'Choose activity',
                    'attr' => array('class' => 'six columns')
                ))
                ->add('gender', 'choice', array(
                    'choices' => array('male' => 'Male', 'female' => 'Female'),
                    'expanded' => true,
                    'label' => 'Male / Female',
                ))
                ->add('activity_start_date', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'MM-dd-yyyy',
                    'attr' => array('class' => 'date six columns')
                ))
                ->add('activity_end_date', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'MM-dd-yyyy',
                    'attr' => array('class' => 'date six columns')
                ))
                ->add('organization')
                ->add('occupation')
                ->add('phone_number')
                ->add('video', 'sonata_media_type', array(
                    'required' => false,
                    'provider' => 'sonata.media.provider.youtube',
                    'context'  => 'user',
                    'label' => 'Video (youtube link)'
                ))
                ->add('volunteer', 'choice', array(
                    'choices' => array(0 => 'No', 1 => 'Yes'),
                    'expanded' => true,
                ))
                ->add('comments', 'textarea', array(
                    'required' => false
                ))
                 ->add('self_description', 'textarea', array(
                    'required' => false
                ))
                ->add('city', 'city_selector', array('attr' => array('placeholder' => 'City name')))


        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('Participant'),
            'cascade_validation' => true,
            'data_class' => "WNC\SoldierBundle\Entity\Participant"
        ));
    }

    public function getName()
    {
        return 'wnc_soldierbundle_participanttype';
    }

}
