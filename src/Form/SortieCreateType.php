<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Sortie en forêt',
                'attr' => [
                    'placeholder' => 'Nom de la sortie',
                    'class' => 'form-control',
                ],
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Début de la sortie',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('heureFin', DateTimeType::class, [
                'label' => 'Fin de la sortie',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('dateLimitInscription', DateTimeType::class, [
                'label' => 'date limite d\'inscription',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('nbInscriptionMax', IntegerType::class, [
                'label' => 'Nombre maximum de participants',
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                ],
            ])
            ->add('infosSortie', TextareaType::class, [
                'label' => 'Informations sur la sortie',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Quelques informations à propos de la sortie ...',
                    'class' => 'form-control',
                ],
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'placeholder' => '--Lieu--',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('participate', CheckboxType::class, [
                'label' => 'Participer à la sortie',
                'label_attr' => [
                    'class' => 'form-check-label',
                ],
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-check',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-success btn-block send-button tx-tfm',
                    'type' => 'submit',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
