<?php

/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/16/2017
 * Time: 12:10 PM
 */
namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',))
            ->add('role', ChoiceType::class, array(
                'mapped' => false,
                'choices' => array(
                    'Employee' => 'ROLE_EMPLOYEE',
                    'Manager' => 'ROLE_MANAGER',
                    'Boss' => 'ROLE_BOSS'
                ),
                'required'    => true,
                'placeholder' => 'Choose role',
                'empty_data'  => null))
            ->add('name')
            ->add('surname')
            ->add('phone_number')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Employee::class,
        ));
    }
}
