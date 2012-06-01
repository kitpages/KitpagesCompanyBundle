<?php

namespace Kitpages\CompanyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class UserCreateFormType extends BaseType
{

    public function getDefaultOptions(array $options)
    {
        return array();
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        // add your custom field
        $builder->add(
            'firstname',
            'text',
            array(
                'required' => false
            )
        );
        $builder->add(
            'lastname',
            'text',
            array(
                'required' => false
            )
        );
        $builder->add(
            'phone',
            'text',
            array(
                'required' => false
            )
        );
//        $builder->add('company', 'entity', array(
//            'class' => 'Kitpages\\CompanyBundle\\Entity\\Company',
//            'empty_value' => 'Choose an company',
//            'required' => true
//        ));
    }

}
