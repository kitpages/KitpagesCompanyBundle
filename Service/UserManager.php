<?php

namespace Kitpages\CompanyBundle\Service;

// external service
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Routing\RouterInterface;

use Kitpages\FileSystemBundle\Service\Adapter\AdapterInterface;

use Kitpages\CompanyBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Kitpages\CompanyBundle\KitpagesCompanyEvents;

class UserManager {
    ////
    // dependency injection
    ////
    protected $doctrine = null;
    protected $dispatcher = null;
    protected $router = null;
    protected $translator = null;


    public function __construct(
        Registry $doctrine,
        EventDispatcherInterface $dispatcher,
        Translator $translator
    )
    {
        $this->doctrine = $doctrine;
        $this->dispatcher = $dispatcher;
        $this->translator = $translator;
    }

    public function userActionList()
    {
        // send on event
        $event = new UserEvent();
        $actionList = array();
        $actionList[] = array(
            'class' => 'btn-standard',
            'label' => $this->translator->trans('Edit'),
            'route' =>  array(
                'name' => 'kitpages_company_admin_company_edit_user',
                'parameterList' => array(
                    "userId" => '$$id$$'
                )
            ),
        );
        $actionList[] = array(
            'class' => 'btn-standard  kit-company-confirm-delete',
            'label' => $this->translator->trans('Delete'),
            'route' =>  array(
                'name' => 'kitpages_company_admin_company_delete_user',
                'parameterList' => array(
                    "userId" => '$$id$$'
                )
            ),
        );
        $event->set('actionList', $actionList);
        $this->dispatcher->dispatch(KitpagesCompanyEvents::afterDisplayActionUser, $event);
        return $event->get('actionList');
    }


}
