<?php

namespace WNC\SoldierBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Symfony\Cmf\Bundle\ContentBundle\Admin\StaticContentAdmin as Base;

class StaticContentAdmin extends Base
{
    

    

    protected function configureFormFields(FormMapper $formMapper)
    {
      
        parent::configureFormFields($formMapper);
      
        $formMapper->add('body','textarea', array(
        'attr' => array(
            'class' => 'tinymce',
            'data-theme' => 'advanced', // simple, advanced, bbcode
            'style' => 'width: 50%; height: 500px;'
        )
        ));
    }

    
}
