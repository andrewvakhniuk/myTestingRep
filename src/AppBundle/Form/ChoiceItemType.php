<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/11/2017
 * Time: 5:28 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\ChoiceItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ChoiceItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',null,[
            'required'    => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ChoiceItem::class,
        ));
    }
}