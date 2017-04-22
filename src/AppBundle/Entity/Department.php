<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * Department
 */
class Department
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
    private $city;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $building;

    /**
     * @var string
     */
    private $phoneNumber;


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
     * @return Department
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
     * Set city
     *
     * @param string $city
     *
     * @return Department
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Department
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set building
     *
     * @param string $building
     *
     * @return Department
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Department
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \AppBundle\Entity\Department
     */
    private $parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
//        $this->employees=new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Department $child
     *
     * @return Department
     */
    public function addChild(\AppBundle\Entity\Department $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Department $child
     */
    public function removeChild(\AppBundle\Entity\Department $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Department $parent
     *
     * @return Department
     */
    public function setParent(\AppBundle\Entity\Department $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Department
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $employees;


    /**
     * Add employee
     *
     * @param \AppBundle\Entity\Employee $employee
     *
     * @return Department
     */
    public function addEmployee(\AppBundle\Entity\Employee $employee)
    {
        //for inverse side of db table
        $employee->setDepartment($this);
        $this->employees[] = $employee;

        return $this;
    }

    /**
     * Remove employee
     *
     * @param \AppBundle\Entity\Employee $employee
     */
    public function removeEmployee(\AppBundle\Entity\Employee $employee)
    {
        //for inverse side of db table
        $employee->setDepartment(null);
        $this->employees->removeElement($employee);
    }

    /**
     * Get employees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployees()
    {
        return $this->employees;
    }
    public function __toString(){
        return (string) $this->getName()." ".$this->getCity();
    }
}
