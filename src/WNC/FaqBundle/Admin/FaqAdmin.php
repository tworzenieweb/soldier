<?php

namespace WNC\FaqBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Evercode\Bundle\FaqBundle\Admin\FaqAdmin as BaseAdmin;

class FaqAdmin extends BaseAdmin
{

    

    public function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        
        $formMapper
            ->add('locale', null, array('required' => true))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        
        $listMapper
            ->addIdentifier('locale')
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper
            ->add('locale')
        ;
    }

}