<?php
namespace WNC\SoldierBundle\Form\Extension\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class JqueryDateType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('datetime_alt', 'datetime', array(
            'required' => true,
            'attr' => array('style' => 'display : none;'),
            'widget' => 'single_text',
            'data' => new \DateTime(),
        ));
    }

    public function getDefaultOptions(array $options) {
        return array(
            'widget' => 'single_text',
            'attr' => array('class' => 'datetimepicker'),
        );
    }

    public function getParent() {
        return 'datetime';
    }

    public function getName() {
        return 'jqueryDate';
    }
}