<?php

namespace WNC\SoldierBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class SoldierAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('mothers_name')
            ->add('picture',  'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'news')))
            ->add('video',  'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'news')))
            ->add('service_end_date')
            ->add('army_unit')
            ->add('wants_to_contact')
            ->add('comments')
            ->add('self_description')
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
            ->add('mothers_name', null, array(
                'label' => 'Mother\'s Name'
            ))
            ->add('user.email', null, array(
                'label' => 'Email'
            ))
            ->add('service_end_date', null, array(
                'label' => 'Service End Date'
            ))
            ->add('army_unit', null, array(
                'label' => 'Army Unit'
            ))
            ->add('wants_to_contact', null, array(
                'label' => 'Wants To Contact'
            ))
            ->add('participant.user', null, array(
                'label' => 'Connected with'
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