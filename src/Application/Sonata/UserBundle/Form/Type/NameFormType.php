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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseForm;

class NameFormType extends BaseForm
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
                ->add('email', 'email', array(
                    'attr' => array(
                        'placeholder' => 'Your Email'
                        ),
                    'label' => 'form.email', 'translation_domain' => 'FOSUserBundle'));
    }

}
