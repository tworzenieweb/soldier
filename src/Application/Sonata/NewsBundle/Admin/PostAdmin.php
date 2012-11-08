<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\NewsBundle\Admin;


use Sonata\NewsBundle\Admin\PostAdmin as BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class PostAdmin extends BaseAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
      
      parent::configureFormFields($formMapper);
      
      
      $formMapper->with('General')
              ->add('image', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'news')))
              ->end();
      
      
       
    }
}
