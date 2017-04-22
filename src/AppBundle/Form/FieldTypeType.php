<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/3/2017
 * Time: 12:35 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\ChoiceItem;
use AppBundle\Entity\FieldType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class FieldTypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')

            ->add('type', ChoiceType::class, array(
//                'mapped' => false,
                'choices' => array(
                    'Text' => null,
                    'Number' => 'Symfony\Component\Form\Extension\Core\Type\NumberType',
                    'Date' => 'Symfony\Component\Form\Extension\Core\Type\DateType',
                    'Big Text'=>'Symfony\Component\Form\Extension\Core\Type\TextareaType',
                    'File'=>'Symfony\Component\Form\Extension\Core\Type\FileType',
                    'Choice drop down list'=>'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                ),
                'required'    => true,
                'placeholder' => 'Choose type of field',
                'empty_data'  => null));

             $builder->add('choiceItems', CollectionType::class, array(
                 'entry_type' => ChoiceItemType::class,
                 'allow_add'    => true,
                 'allow_delete' => true,
                 'by_reference' => false,
                 'prototype' => true,
                 'prototype_name'=>'__choiceItems__'
             ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => FieldType::class
        ));
    }


}
