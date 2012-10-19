<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WNC\SoldierBundle\Admin;

use Sonata\UserBundle\Admin\Model\UserAdmin as Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use FOS\UserBundle\Model\UserManagerInterface;

class UserAdmin extends Admin
{

//    /**
//     * {@inheritdoc}
//     */
//    protected function configureListFields(ListMapper $listMapper)
//    {
//        $listMapper
//            ->addIdentifier('username')
//            ->addIdentifier('firstname')
//            ->addIdentifier('lastname')
//            ->add('email')
//            ->add('createdAt')
//        ;
//
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    protected function configureDatagridFilters(DatagridMapper $filterMapper)
//    {
//        $filterMapper
//            ->add('id')
//            ->add('username')
//            ->add('email')
//        ;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    protected function configureShowFields(ShowMapper $showMapper)
//    {
//        $showMapper
//            ->with('General')
//                ->add('email')
//            ->end()
//            ->with('Profile')
//                ->add('firstname')
//                ->add('lastname')
//            ->end()
//        ;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    protected function configureFormFields(FormMapper $formMapper)
//    {
//        $formMapper
//            ->with('General')
//                ->add('email')
//            ->end()
//            ->with('Profile')
//                ->add('firstname', null, array('required' => false))
//                ->add('lastname', null, array('required' => false))
//            ->end()
//        ;
//
//        
//        
//    }

}
