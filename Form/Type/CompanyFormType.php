<?php

namespace Kitpages\CompanyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Symfony\Bundle\DoctrineBundle\Registry;

class CompanyFormType extends AbstractType
{


    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add(
            'name',
            "text",
            array(
                "label" => "Name"
            )
        );
        $builder->add(
            'address',
            "textarea",
            array(
                "label" => "Address",
                'required' => false,
            )
        );
        $builder->add(
            'country',
            "country",
            array(
                "label" => "Country",
                'required' => false
            )
        );

        $builder->add(
            'phone',
            "text",
            array(
                "label" => "Phone",
                'required' => false,
            )
        );
        $builder->add(
            'email',
            "text",
            array(
                "label" => "Email",
                'required' => false,
            )
        );
        $builder->add(
            'urlSite',
            "text",
            array(
                "label" => "Url",
                'required' => false,
            )
        );
        $builder->add(
            'logo',
            'file',
            array(
                "label" => "Logo",
                'required' => false
            )
        );
    }

    public function getName()
    {
        return 'kitpages_companybundle_companyform';
    }
}
