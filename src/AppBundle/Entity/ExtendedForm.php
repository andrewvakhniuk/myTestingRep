<?php

namespace AppBundle\Entity;

/**
 * Form
 */
class ExtendedForm
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
     * @return ExtendedForm
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $fieldTypes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fieldTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add fieldType
     *
     * @param \AppBundle\Entity\FieldType $fieldType
     *
     * @return ExtendedForm
     */
    public function addFieldType(\AppBundle\Entity\FieldType $fieldType)
    {
        $fieldType->setExtendedForm($this);
        $this->fieldTypes[] = $fieldType;

        return $this;
    }

    /**
     * Remove fieldType
     *
     * @param \AppBundle\Entity\FieldType $fieldType
     */
    public function removeFieldType(\AppBundle\Entity\FieldType $fieldType)
    {
        $fieldType->setExtendedForm(null);
        $this->fieldTypes->removeElement($fieldType);
    }

    /**
     * Get fieldTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFieldTypes()
    {
        return $this->fieldTypes;
    }
}
