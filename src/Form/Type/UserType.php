<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('nume',TextType::class)
            ->add('mail',EmailType::class)
            ->add ('parola',PasswordType::class)
            ->add('birthday',BirthdayType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 0,
                    'Female' => 1,
                    'Don\'t specify' => 2,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('submit',SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}