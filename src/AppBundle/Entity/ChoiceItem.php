<?php

namespace AppBundle\Entity;

/**
 * ChoiceItem
 */
class ChoiceItem
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
     * @return ChoiceItem
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
     * @var \AppBundle\Entity\FieldType
     */
    private $fieldType;


    /**
     * Set fieldType
     *
     * @param \AppBundle\Entity\FieldType $fieldType
     *
     * @return ChoiceItem
     */
    public function setFieldType(\AppBundle\Entity\FieldType $fieldType = null)
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * Get fieldType
     *
     * @return \AppBundle\Entity\FieldType
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }
}
