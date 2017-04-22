<?php

namespace AppBundle\Entity;

/**
 * Customer
 */
class Customer
{
    /**
     * @var int
     */
    private $id;

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
     * @var string
     */
    private $specialization;


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
     * Set name
     *
     * @param string $name
     *
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * Set specialization
     *
     * @param string $specialization
     *
     * @return Customer
     */
    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;

        return $this;
    }

    /**
     * Get specialization
     *
     * @return string
     */
    public function getSpecialization()
    {
        return $this->specialization;
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $institutions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reports = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->institutions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add report
     *
     * @param \AppBundle\Entity\Report $report
     *
     * @return Customer
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
     * @return Customer
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

    /**
     * Add institution
     *
     * @param \AppBundle\Entity\Institution $institution
     *
     * @return Customer
     */
    public function addInstitution(\AppBundle\Entity\Institution $institution)
    {
//        $institution->addCustomer($this);
        $this->institutions[] = $institution;

        return $this;
    }

    /**
     * Remove institution
     *
     * @param \AppBundle\Entity\Institution $institution
     */
    public function removeInstitution(\AppBundle\Entity\Institution $institution)
    {
        $this->institutions->removeElement($institution);
    }

    /**
     * Get institutions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstitutions()
    {
        return $this->institutions;
    }

    public function __toString(){
        return (string) $this->getName()." ".$this->getSurname();
    }
}
