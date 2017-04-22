<?php

namespace AppBundle\Entity;

/**
 * Plan
 */
class Plan
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
    private $task;

    /**
     * @var string
     */
    private $product;

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
     * @return Plan
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
     * Set task
     *
     * @param string $task
     *
     * @return Plan
     */
    public function setTask($task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return string
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set product
     *
     * @param string $product
     *
     * @return Plan
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Plan
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
     * @var \AppBundle\Entity\Report
     */
    private $report;

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
     * Set report
     *
     * @param \AppBundle\Entity\Report $report
     *
     * @return Plan
     */
    public function setReport(\AppBundle\Entity\Report $report = null)
    {
        $report->setPlan($this);
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return \AppBundle\Entity\Report
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Set institution
     *
     * @param \AppBundle\Entity\Institution $institution
     *
     * @return Plan
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
     * @return Plan
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
     * @return Plan
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
        return (string) $this->getDate()->format('Y-m-d H:i:s')." ".$this->getTask();
    }
}
