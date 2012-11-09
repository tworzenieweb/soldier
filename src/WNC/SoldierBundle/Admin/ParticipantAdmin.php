<?php

namespace WNC\SoldierBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class ParticipantAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('birth_date')
            ->add('city', 'city_selector')
            ->add('activity')
            ->add('phone_number')
            ->add('occupation')
            ->add('activity_start_date')
            ->add('activity_end_date')
            ->add('volunteer')
            ->add('organization')
            ->add('comments', 'textarea')
            ->add('self_description', 'textarea')
            ->add('picture',  'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'news')))
            ->add('video',  'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'news')))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('picture', 'string', array('template' => 'ApplicationSonataMediaBundle:MediaAdmin:list_image_participant.html.twig'))
            ->add('user.firstname', null, array(
                'label' => 'Firstname'
            ))
            ->add('user.lastname', null, array(
                'label' => 'Lastname'
            ))
            ->add('user.email', null, array(
                'label' => 'Email'
            ))
            ->add('city.name', null, array(
                'label' => 'City'
            ))
            ->add('activity.name', null, array(
                'label' => 'Activity'
            ))
            ->add('phone_number', null, array(
                'label' => 'Phone'
            ))
            ->add('occupation', null, array(
                'label' => 'Occupation'
            ))
            ->add('activity_start_date', null, array(
                'label' => 'Activity starts'
            ))
            ->add('activity_end_date', null, array(
                'label' => 'Activity ends'
            ))
            ->add('birth_date', null, array(
                'label' => 'Birth Date'
            ))
            ->add('volunteer', null, array(
                'label' => 'Volunteer'
            ))
            ->add('organization', null, array(
                'label' => 'Organization'
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {

    }
}