<?php

/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/16/2017
 * Time: 12:10 PM
 */
namespace AppBundle\Form;

use AppBundle\Entity\Department;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DepartmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $employees=$options['employees'];
        $departments=$options['departments'];

        $builder
            ->add('name')
            ->add('city')
            ->add('street')
            ->add('building')
            ->add('phone_number')
            ->add('employees', EntityType::class, [
                'class'        => 'AppBundle:Employee',
                'choices' => ["Employees:"=>$employees],
//                'mapped'=>true,
//            to the inverse side of DB for saving customers to db (manyToMany relation)
                'by_reference' => false,

//                'expanded'     => true,
                'label'        => 'Choose Employees:',
                'multiple'     => true,
                'required'    => false,
            ])
            ->add('parent', EntityType::class, [
                'class'        => 'AppBundle:Department',
                'choices' => $departments,
                'required'    => false,
                'placeholder' => '--',
//                'mapped'=>true,
//                'by_reference' => true,
//                'expanded'     => false,
                'label'        => 'Choose Parent Department:',
                'multiple'     => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Department::class,
            'employees'=>null,
            'departments'=>null,
        ));
    }
}
