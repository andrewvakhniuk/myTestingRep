<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/16/2017
 * Time: 3:16 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Plan;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PlanType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $institutions=$options['institutions'];
        $reports=$options['reports'];
        $customers=$options['customers'];

        $builder
//            ->add('date',DateTimeType::class,array(
//                'placeholder' => array(
//                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
//                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
//                )))
            ->add('date', DateType::class, array(
                'widget' => 'choice',
            ))
            ->add('task',TextareaType::class)
            ->add('product')
            ->add('Comment',TextareaType::class)
            ->add('institution', EntityType::class, [
                'class'        => 'AppBundle:Institution',
                'choices' => ["Institutions:"=>$institutions],
//                'mapped'=>true,
//                'by_reference' => false,
//                'expanded'     => true,
                'label'        => 'Choose Institution:',
                'multiple'     => false,
                'required'    => false,
                'placeholder' => "--",
            ])
            ->add('customer', EntityType::class, [
                'class'        => 'AppBundle:Customer',
                'choices' => ["Customers:"=>$customers],
                'label'        => 'Choose Customer:',
                'multiple'     => false,
                'required'    => false,
                'placeholder' => "--",
            ])
            ->add('report', EntityType::class, [
                'class'        => 'AppBundle:Report',
                'choices' => ["Reports:"=>$reports],
                'label'        => 'Choose Report:',
                'multiple'     => false,
                'required'    => false,
                'placeholder' => "--",
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Plan::class,
            'institutions'=>null,
            'reports'=>null,
            'customers'=>null,
        ));
    }
}