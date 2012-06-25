<?php
 
namespace Kitpages\CompanyBundle\Form\Type;
 
use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
 
class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilder $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        $builder->add('email', 'email');
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
 
    public function getName()
    {
        return 'kitpages_company_profile';
    }
}