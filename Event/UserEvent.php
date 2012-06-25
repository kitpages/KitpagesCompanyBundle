<?php
namespace Kitpages\CompanyBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Kitpages\CompanyBundle\Entity\User;

class UserEvent extends Event
{
    protected $data = array();
    protected $user = null;
    protected $isPrevented = false;

    public function __construct()
    {
    }

    /**
     * @Param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function set($key, $val)
    {
        $this->data[$key] = $val;
    }

    public function get($key)
    {
        if (!array_key_exists($key, $this->data)) {
            return null;
        }
        return $this->data[$key];
    }

    public function preventDefault()
    {
        $this->isPrevented = true;
    }

    public function isDefaultPrevented()
    {
        return $this->isPrevented;
    }
}
