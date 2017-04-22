<?php

namespace AppBundle\Form;

use AppBundle\Entity\Report;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use AppBundle\Listener\FormSubscriber;



class ReportType extends AbstractType
{
    protected $formSubscriber;
    public function __construct(FormSubscriber $formSubscriber)
    {
     $this->formSubscriber=$formSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->name2='aasdf';


        $institutions=$options['institutions'];
        $plans=$options['plans'];
        $customers=$options['customers'];
        $fieldTypes=$options['fieldTypes'];

        $builder
            ->add('date', DateType::class)
//                array(
//                'widget' => 'choice',
//            ))
//            ->add('date',DateTimeType::class,array(
//                'placeholder' => array(
//                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
//                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
//                )))
            ->add('product')
            ->add('countity',NumberType::class)
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
            ->add('plan', EntityType::class, [
                'class'        => 'AppBundle:Plan',
                'choices' => ["Plans:"=>$plans],
                'label'        => 'Choose Plan:',
                'multiple'     => false,
                'required'    => false,
                'placeholder' => "--",
            ])
        ;
        $this->formSubscriber->setFormName('a');
        $builder->addEventSubscriber($this->formSubscriber);
//        if($fieldTypes){
//            foreach ($fieldTypes as $item){
//                $builder->add($item->getName(),$item->getType(),[
//                    'mapped'=>false,
//                ]);
//            }
//        }
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Report::class,
            'institutions'=>null,
            'plans'=>null,
            'customers'=>null,
            'fieldTypes'=>null,
        ));
    }

}
