<?php

namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $loginHistories;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->loginHistories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add loginHistory
     *
     * @param \AppBundle\Entity\LoginHistory $loginHistory
     *
     * @return User
     */
    public function addLoginHistory(\AppBundle\Entity\LoginHistory $loginHistory)
    {
        $this->loginHistories[] = $loginHistory;

        return $this;
    }

    /**
     * Remove loginHistory
     *
     * @param \AppBundle\Entity\LoginHistory $loginHistory
     */
    public function removeLoginHistory(\AppBundle\Entity\LoginHistory $loginHistory)
    {
        $this->loginHistories->removeElement($loginHistory);
    }

    /**
     * Get loginHistories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLoginHistories()
    {
        return $this->loginHistories;
    }
}
