<?php
namespace Kitpages\CompanyBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

class User extends BaseUser
{
    /**
     * @var string $lastname
     */
    private $lastname;

    /**
     * @var string $firstname
     */
    private $firstname;

    /**
     * @var string $phone
     */
    private $phone;

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Kitpages\CompanyBundle\Entity\Group
     */
    private $group;

    /**
     * @var Kitpages\CompanyBundle\Entity\Company
     */
    private $company;


    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
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
     * Set group
     *
     * @param Kitpages\CompanyBundle\Entity\Group $group
     */
    public function setGroup(\Kitpages\CompanyBundle\Entity\Group $group)
    {
        $this->group = $group;
    }

    /**
     * Get group
     *
     * @return Kitpages\CompanyBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set company
     *
     * @param Kitpages\CompanyBundle\Entity\Company $company
     */
    public function setCompany(\Kitpages\CompanyBundle\Entity\Company $company)
    {
        $this->company = $company;
    }

    /**
     * Get company
     *
     * @return Kitpages\CompanyBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }
}