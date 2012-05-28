<?php
namespace Kitpages\CompanyBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;

class Company
{

    private $logo;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var text $address
     */
    private $address;

    /**
     * @var string $phone
     */
    private $phone;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $country
     */
    private $country;

    /**
     * @var string $urlSite
     */
    private $urlSite;

    /**
     * @var string $logoPath
     */
    private $logoPath;

    /**
     * @var datetime $createdAt
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     */
    private $updatedAt;

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var Kitpages\CompanyBundle\Entity\User
     */
    private $userList;

    public function __construct()
    {
        $this->userList = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param text $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return text 
     */
    public function getAddress()
    {
        return $this->address;
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
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set urlSite
     *
     * @param string $urlSite
     */
    public function setUrlSite($urlSite)
    {
        $this->urlSite = $urlSite;
    }

    /**
     * Get urlSite
     *
     * @return string 
     */
    public function getUrlSite()
    {
        return $this->urlSite;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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


    /**
     * Set logoPath
     *
     * @param string $logoPath
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;
    }

    /**
     * Get logoPath
     *
     * @return string
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    public function getLogo() {
      return $this->logo;
    }

    public function setLogo(File $file = null) {
      $this->logo = $file;
    }


    /**
     */
    public function preUpload()
    {
        if (null !== $this->logo) {
            $this->logoPath = '.'.$this->logo->guessExtension();
        }
    }

    /**
     */
    public function upload()
    {
        if (null === $this->logo) {
            return;
        }

        if (!is_dir($this->getUploadRootDir())) {
            mkdir($this->getUploadRootDir(), 0700, true);
        }
        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->logo->move($this->getUploadRootDir(), $this->id.$this->logoPath);

        unset($this->logo);
    }

    /**
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->logoPath ? null : $this->getUploadRootDir().'/'.$this->id.$this->logoPath;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/data/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'bundle/KitpagesCompany/company/logo';
    }

    public function getUrlLogo()
    {
        return null === $this->logoPath ? null : '/data/'.$this->getUploadDir().'/'.$this->id.$this->logoPath;
    }

    /**
     * @var boolean $ownerCompany
     */
    private $ownerCompany;


    /**
     * Set ownerCompany
     *
     * @param boolean $ownerCompany
     */
    public function setOwnerCompany($ownerCompany)
    {
        $this->ownerCompany = $ownerCompany;
    }

    /**
     * Get ownerCompany
     *
     * @return boolean 
     */
    public function getOwnerCompany()
    {
        return $this->ownerCompany;
    }
}