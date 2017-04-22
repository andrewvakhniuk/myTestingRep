<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/3/2017
 * Time: 11:47 AM
 */

namespace AppBundle\Entity;


class FieldValue
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    /**
     * @var \AppBundle\Entity\FieldType
     */
    private $fieldType;


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
     * Set value
     *
     * @param string $value
     *
     * @return FieldValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set fieldType
     *
     * @param \AppBundle\Entity\FieldType $fieldType
     *
     * @return FieldValue
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


    /**
     * @var integer
     */
    private $dataclassId;

    /**
     * @var string
     */
    private $dataclassName;


    /**
     * Set dataclassId
     *
     * @param integer $dataclassId
     *
     * @return FieldValue
     */
    public function setDataclassId($dataclassId)
    {
        $this->dataclassId = $dataclassId;

        return $this;
    }

    /**
     * Get dataclassId
     *
     * @return integer
     */
    public function getDataclassId()
    {
        return $this->dataclassId;
    }

    /**
     * Set dataclassName
     *
     * @param string $dataclassName
     *
     * @return FieldValue
     */
    public function setDataclassName($dataclassName)
    {
        $this->dataclassName = $dataclassName;

        return $this;
    }

    /**
     * Get dataclassName
     *
     * @return string
     */
    public function getDataclassName()
    {
        return $this->dataclassName;
    }
}
