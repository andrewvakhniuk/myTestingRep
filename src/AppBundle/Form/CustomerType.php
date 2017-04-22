<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/16/2017
 * Time: 3:16 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CustomerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $institutions=$options['institutions'];

        $builder
            ->add('name')
            ->add('surname')
            ->add('specialization')
            ->add('phone_number')
            ->add('institutions', EntityType::class, [
                'class'        => 'AppBundle:Institution',
                'choices' => ["Institutions:"=>$institutions],
//                'mapped'=>true,
//            to the inverse side of DB for saving customers to db (manyToMany relation)
                'by_reference' => false,

//                'expanded'     => true,
                'label'        => 'Choose Institutions:',
                'multiple'     => true,
                'required'    => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Customer::class,
            'institutions'=>null,
        ));
    }
}