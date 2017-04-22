<?php

namespace AppBundle\Entity;

/**
 * Report
 */
class Report
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $product;

    /**
     * @var int
     */
    private $countity;

    /**
     * @var string
     */
    private $comment;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Report
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set product
     *
     * @param string $product
     *
     * @return Report
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set countity
     *
     * @param integer $countity
     *
     * @return Report
     */
    public function setCountity($countity)
    {
        $this->countity = $countity;

        return $this;
    }

    /**
     * Get countity
     *
     * @return int
     */
    public function getCountity()
    {
        return $this->countity;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Report
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * @var \AppBundle\Entity\Plan
     */
    private $plan;

    /**
     * @var \AppBundle\Entity\Institution
     */
    private $institution;

    /**
     * @var \AppBundle\Entity\Customer
     */
    private $customer;

    /**
     * @var \AppBundle\Entity\Employee
     */
    private $employee;


    /**
     * Set plan
     *
     * @param \AppBundle\Entity\Plan $plan
     *
     * @return Report
     */
    public function setPlan(\AppBundle\Entity\Plan $plan = null)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return \AppBundle\Entity\Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Set institution
     *
     * @param \AppBundle\Entity\Institution $institution
     *
     * @return Report
     */
    public function setInstitution(\AppBundle\Entity\Institution $institution = null)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution
     *
     * @return \AppBundle\Entity\Institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Report
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee $employee
     *
     * @return Report
     */
    public function setEmployee(\AppBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \AppBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }
    public function __toString(){

        return (string) $this->getDate()->format('Y-m-d H:i:s')." ".$this->getComment();
    }



}
