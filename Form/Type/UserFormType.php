<?php

namespace Kitpages\CompanyBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;
use Kitpages\CompanyBundle\Entity\Group;

class UserFormType extends AbstractType
{

    public function getDefaultOptions(array $options)
    {
        return array();
    }

    public function getName()
    {
        return 'kitpages_company_user_create_form';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('username')
            ->add('email', 'email')
            ->add('firstname', 'text')
            ->add('lastname', 'text');
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
    }
}
