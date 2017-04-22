<?php

namespace AppBundle\Form;

use AppBundle\Entity\ExtendedForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ExtendedFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('fieldTypes', CollectionType::class, array(
            'entry_type' => FieldTypeType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
            'prototype' => true,
            'prototype_name'=> '__fieldTypes__'

        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ExtendedForm::class
        ));
    }


}
