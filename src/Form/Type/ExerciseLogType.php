<?php

namespace App\Form\Type;

use App\Entity\ExerciseLog;
use App\Entity\Workout;
use App\Entity\Exercise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciseLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('exercise', EntityType::class, [
                'class' => Exercise::class,
                'choice_label' => function (Exercise $exercise) {
                    return $exercise->getName();
                },
            ])
            ->add('nr_reps', IntegerType::class)
            ->add('duration', TimeType::class, [
                'widget' => 'choice',
                'hours' => range(0, 0),
                'minutes' => range(0, 59),
                'seconds' => range(0, 59),
                'with_seconds' => true,
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExerciseLog::class,
        ]);
    }
}
