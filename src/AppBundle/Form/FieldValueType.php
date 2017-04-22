<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/6/2017
 * Time: 12:51 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\Institution;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FieldValueType  extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field=$options['field'];

        $builder->add($field->getName(),$field->getType(),[
            'mapped'=>false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Institution::class,
            'field'=>null,
        ));
    }
}