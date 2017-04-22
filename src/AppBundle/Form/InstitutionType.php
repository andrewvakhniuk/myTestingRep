<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/16/2017
 * Time: 3:18 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\Institution;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InstitutionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $customers=$options['customers'];
        $builder
            ->add('specialization')
            ->add('city')
            ->add('street')
            ->add('building')
            ->add('customers', EntityType::class, [
                'class'        => 'AppBundle:Customer',
                'choices' => ["Customers:"=>$customers],
//                'mapped'=>false,
//            to the inverse side of DB for saving customers to db (manyToMany relation)
                'by_reference' => false,
//                'expanded'     => true,
                'label'        => 'Choose Customers:',
                'multiple'     => true,
                'required'    => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Institution::class,
            'customers'=>null,
        ));
    }
}