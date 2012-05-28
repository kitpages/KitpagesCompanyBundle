<?php
namespace Kitpages\CompanyBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

class Group extends BaseGroup
{

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Kitpages\CompanyBundle\Entity\User
     */
    private $userList;

    public function __construct()
    {
        $this->userList = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add userList
     *
     * @param Kitpages\CompanyBundle\Entity\User $userList
     */
    public function addUser(\Kitpages\CompanyBundle\Entity\User $userList)
    {
        $this->userList[] = $userList;
    }

    /**
     * Get userList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUserList()
    {
        return $this->userList;
    }


}