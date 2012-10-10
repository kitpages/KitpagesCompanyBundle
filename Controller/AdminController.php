<?php


namespace Kitpages\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Kitpages\CompanyBundle\Entity\Company;
use Kitpages\CompanyBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Kitpages\DataGridBundle\Model\GridConfig;
use Kitpages\DataGridBundle\Model\Field;
use Kitpages\CompanyBundle\Event\UserEvent;
use Kitpages\CompanyBundle\KitpagesCompanyEvents;

class AdminController extends Controller
{
    public function companyListAction()
    {

        // create query builder
        $em = $this->get('doctrine')->getEntityManager();
        $repository = $em->getRepository('KitpagesCompanyBundle:Company');
        $queryBuilder = $repository->createQueryBuilder("item");

        $gridConfig = new GridConfig();
        $gridConfig->setCountFieldName("item.id");
        $gridConfig->addField(new Field("item.name", array("label" => "Name", "filterable"=>true)));
        $gridConfig->addField(new Field("item.phone", array("label" => "Phone", "filterable"=>true)));
        $gridConfig->addField(new Field("item.email", array("label" => "Email", "filterable"=>true)));

        $gridManager = $this->get("kitpages_data_grid.manager");
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $this->getRequest());

        return $this->render('KitpagesCompanyBundle:Admin/company:list.html.twig', array(
            "grid" => $grid
        ));
    }

    public function userListAction($companyId)
    {

        // create query builder
        $em = $this->get('doctrine')->getEntityManager();
        $repository = $em->getRepository('KitpagesCompanyBundle:User');
        $queryBuilder = $repository->createQueryBuilder("item")
            ->join('item.company', 'g')
            ->where('g.id = :companyId')
            ->setParameter('companyId', $companyId);

        $gridConfig = new GridConfig();
        $gridConfig->setCountFieldName("item.id");
        $gridConfig->addField(new Field("item.username", array("label" => "Username", "filterable"=>true)));
        $gridConfig->addField(new Field("item.lastname", array("label" => "Lastname", "filterable"=>true)));
        $gridConfig->addField(new Field("item.firstname", array("label" => "Firstname", "filterable"=>true)));
        $gridConfig->addField(new Field("item.email", array("label" => "Email", "filterable"=>true)));
        $gridConfig->addField(new Field("item.phone", array("label" => "Phone", "filterable"=>true)));

        $gridManager = $this->get("kitpages_data_grid.manager");
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $this->getRequest());

        $company = $em->getRepository('KitpagesCompanyBundle:Company')->find($companyId);

        $actionList = $this->get('kitpages_company.user.manager')->userActionList();



        return $this->render('KitpagesCompanyBundle:Admin/company:userList.html.twig', array(
            "grid" => $grid,
            "company" => $company,
            "actionList" => $actionList
        ));
    }

    /**
     * Edit a user
     */
    public function userEditAction($userId)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $user = $em->getRepository('KitpagesCompanyBundle:User')->find($userId);

        $form = $this->container->get('kitpages_company.user.form');
        $formHandler = $this->container->get('kitpages_company.user.form.handler');
        $process = $formHandler->process($user);
        if ($process) {
            $this->getRequest()->getSession()->setFlash('fos_user_success', 'profile.flash.updated');
            return new RedirectResponse($this->get('router')->generate('kitpages_company_admin_company_list_user', array('companyId' => $user->getCompany()->getId())));
        }

        return $this->container->get('templating')->renderResponse(
            'KitpagesCompanyBundle:Admin:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
            array(
                'kit_user_id' => $user->getId(),
                'form' => $form->createView(),
                'theme' => $this->container->getParameter('fos_user.template.theme')
            )
        );
    }

    /**
     * Delete a user
     */
    public function userDeleteAction($userId)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $user = $em->getRepository('KitpagesCompanyBundle:User')->find($userId);

        // send on event
        $event = new UserEvent();
        $event->setUser($user);
        $this->get('event_dispatcher')->dispatch(KitpagesCompanyEvents::onDeleteUser, $event);
        $companyId = $user->getCompany()->getId();
        if (! $event->isDefaultPrevented()) {
            $this->container->get('fos_user.user_manager')->deleteUser($user);
        }
        // send after event
        $this->get('event_dispatcher')->dispatch(KitpagesCompanyEvents::afterDeleteUser, $event);

        return new RedirectResponse($this->container->get('router')->generate(
            'kitpages_company_admin_company_list_user',
            array(
                'companyId' => $companyId
            )

        ));
    }

    public function userCreateAction($group, $companyId)
    {
        $form = $this->container->get('kitpages_company.user.create.form');
        $formHandler = $this->container->get('kitpages_company.user.create.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        $em = $this->get('doctrine')->getEntityManager();
        $company = $em->getRepository('KitpagesCompanyBundle:Company')->find($companyId);
        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();



            $user->setCompany($company);

            $group = $this->get('fos_user.group_manager')->findGroupByName($group);
            $user->setGroup($group);
            $user->setRoles($group->getRoles());
            $this->get('fos_user.user_manager')->updateUser($user);

            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
            }

            $this->getRequest()->getSession()->setFlash('fos_user_success', 'registration.flash.user_created');
            return $this->redirect($this->get('router')->generate('kitpages_company_admin_company_list_user', array('companyId' => $companyId)));
        }

        return $this->container->get('templating')->renderResponse('KitpagesCompanyBundle:Admin:create.html.'.$this->container->getParameter('fos_user.template.engine'), array(
            'form' => $form->createView(),
            'company' => $company,
            'group' => $group,
            'theme' => $this->container->getParameter('fos_user.template.theme')
        ));
    }

    public function companyCreateAction()
    {
        $entity = new Company();
        $companyForm = $this->container->get('kitpages_company.company.form');
        // build basic form
        $form   = $this->createForm($companyForm, $entity);
        $formHandler = $this->container->get('kitpages_company.company.form.handler');
        $process = $formHandler->process($form, $entity);

        if ($process) {
            return $this->redirect($this->get('router')->generate('kitpages_company_admin_company_list'));
        }

        return $this->render('KitpagesCompanyBundle:Admin/company:company.html.twig', array(
            'form'   => $form->createView()
        ));
    }

    public function companyEditAction($id)
    {

        $em = $this->get('doctrine')->getEntityManager();
        $entity = $em->getRepository('KitpagesCompanyBundle:Company')->find($id);

        $companyForm = $this->container->get('kitpages_company.company.form');
        // build basic form
        $form   = $this->createForm($companyForm, $entity);
        $formHandler = $this->container->get('kitpages_company.company.form.handler');
        $process = $formHandler->process($form, $entity);

        if ($process) {
            return $this->redirect($this->get('router')->generate('kitpages_company_admin_company_list'));
        }

        return $this->render('KitpagesCompanyBundle:Admin/company:company.html.twig', array(
            'form'   => $form->createView()
        ));
    }

}
