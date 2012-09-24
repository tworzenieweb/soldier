<?php

namespace WNC\SoldierBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use WNC\SoldierBundle\Form\DataTransformer\CityToIdTransformer;
use Doctrine\Common\Persistence\ObjectManager;

class CityType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $transformer = new CityToIdTransformer($this->om);
        $builder->prependNormTransformer($transformer);
    }

    public function getDefaultOptions(array $options)
    {
        return array(
           
        );
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'city_selector';
    }
}