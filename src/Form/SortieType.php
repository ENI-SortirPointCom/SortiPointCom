<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de la sortie',
                    'class' => 'form-control'
                ]
            ])
            ->add('dateHeureDebut', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Debut de la sortie',
                    'class' => 'form-control datetimepicker-input',
                    'data-target' => '#datetimepicker7'
                ]
            ])
            ->add('heureFin', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Fin de la sortie',
                    'class' => 'form-control'
                ]
            ])
            ->add('dateLimitInscription', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Date limite d\'inscription',
                    'class' => 'form-control'
                ]
            ])
            ->add('nbInscriptionMax', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nombre maximum de participants',
                    'class' => 'form-control'
                ]
            ])
            ->add('infosSortie', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Informations sur la sorti',
                    'class' => 'form-control'
                ]
            ])
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'placeholder' => '--Etat--',
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'placeholder' => '--Lieu--',
                'attr' => [
                    'class' => 'form-control'
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
