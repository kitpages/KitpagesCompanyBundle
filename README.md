KitpagesEdmBundle
=================

This Symfony2 Bundle extends FOSUserBundle.
Adds an administration to manage users and a user's company

Actual state
============
Under development

Dependencies
============
- FOSUserBundle

add the following entries to the deps in the root of your project file:

    [FOSUserBundle]
        git=http://github.com/FriendsOfSymfony/FOSUserBundle.git
        target=bundles/FOS/UserBundle
        version=1.2.0

Add the following entries to your autoloader:
        $bundles = array(
        ...
            new FOS\UserBundle\FOSUserBundle(),
        );

Installation
============
You need to add the following lines in your deps :

    [CompanyBundle]
        git=git://github.com/kitpages/KitpagesCompanyBundle.git
        target=Kitpages/CompanyBundle

AppKernel.php
        $bundles = array(
        ...
            new Kitpages\CompanyBundle\KitpagesCompanyBundle(),
        );

app/config/routing.yml
    KitpagesCompanyBundle:
        resource: "@KitpagesCompanyBundle/Resources/config/routing.yml"
        prefix:   /

Configuration FOSUserBundle
============
    fos_user:
        user_class: Kitpages\CompanyBundle\Entity\User
        group:
          group_class: Kitpages\CompanyBundle\Entity\Group

Configuration
=============
you must specify a company owner in database
