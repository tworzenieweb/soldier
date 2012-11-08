<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\NewsBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class PostType extends AbstractType
{

    protected $provider;
    
    public function __construct($provider = 'sonata.media.provider.image')
    {
        $this->provider = $provider ? $provider : 'sonata.media.provider.image';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    
        $builder
            ->add('enabled', 'hidden', array(
            'data' => 1
            ))
            ->add('contentFormatter','sonata_formatter_type_selector', array(
                    'source' => 'rawContent',
                    'target' => 'content',
                ))
            ->add('commentsDefaultStatus', 'hidden', array('data' => 1))
            ->add('title')
            ->add('abstract', 'textarea', array(
            'attr' => array('placeholder' => 'This will be used for sliders and posts list')
            ))
            ->add('rawContent', 'textarea', array(
            'label' => 'Content',
            'attr' => array('placeholder' => 'Full post content')
            ))
            ->add('mediaType','choice', array(
            'label' => 'Choose media type to include',
            'choices'   => 
                array(
                ''   => 'None',
                'sonata.media.provider.youtube'   => 'Youtube',
                'sonata.media.provider.image' => 'Image',
                'sonata.media.provider.vimeo'   => 'Vimeo',
            ),
            'mapped' => false,
            'required' => false,
            'data' => $this->provider
    ))
             ->add('image', 'sonata_media_type', array(
                    'required' => false,
                    'provider' => $this->provider,
                    'context'  => 'news',
                    'label' => 'Picture'
                ));
    }

    /**
     * {@inheritdoc}
     */
    function getName()
    {
        return 'sonata_post_post';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => "Application\Sonata\NewsBundle\Entity\Post"
        ));
    }
}
