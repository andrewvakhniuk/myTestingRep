<?php

namespace AppBundle\Entity;

/**
 * Employee
 */
class Employee extends User
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $phoneNumber;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Employee
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set surname
     *
     * @param string $surname
     *
     * @return Employee
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Employee
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    /**
     * @var \AppBundle\Entity\Department
     */
    private $department;


    /**
     * Set department
     *
     * @param \AppBundle\Entity\Department $department
     *
     * @return Employee
     */
    public function setDepartment(\AppBundle\Entity\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \AppBundle\Entity\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $reports;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $plans;


    /**
     * Add report
     *
     * @param \AppBundle\Entity\Report $report
     *
     * @return Employee
     */
    public function addReport(\AppBundle\Entity\Report $report)
    {
        $this->reports[] = $report;

        return $this;
    }

    /**
     * Remove report
     *
     * @param \AppBundle\Entity\Report $report
     */
    public function removeReport(\AppBundle\Entity\Report $report)
    {
        $this->reports->removeElement($report);
    }

    /**
     * Get reports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReports()
    {
        return $this->reports;
    }

    /**
     * Add plan
     *
     * @param \AppBundle\Entity\Plan $plan
     *
     * @return Employee
     */
    public function addPlan(\AppBundle\Entity\Plan $plan)
    {
        $this->plans[] = $plan;

        return $this;
    }

    /**
     * Remove plan
     *
     * @param \AppBundle\Entity\Plan $plan
     */
    public function removePlan(\AppBundle\Entity\Plan $plan)
    {
        $this->plans->removeElement($plan);
    }

    /**
     * Get plans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlans()
    {
        return $this->plans;
    }
    public function __toString(){
        return (string) $this->getName()." ".$this->getSurname();
    }
}
