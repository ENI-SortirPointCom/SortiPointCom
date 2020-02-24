<?php

namespace App\Form;

use App\Entity\Search;
use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class SortieFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organisateur', CheckboxType::class, [
                'label' => 'Sortie dont je suis organisateur/trice',
                'required' => false

            ])
            ->add('etatInscrit', ChoiceType::class, [
                'label' => 'Sorties',
                'required' => false,
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'choices' => [
                    'Toute' => null,
                    'Auquelles je suis inscrit/e' => false,
                    'Auquelles je ne suis pas inscrit/e' => true,
                ],
            ])
            ->add('passe', CheckboxType::class, [
                'label' => 'Sorties passées',
                'required' => false
            ])
            ->add('siteSortie', EntityType::class, [
                'class' => Site::class,
                'required' => false
            ])
            ->add('nomSearch', TextType::class, [
                'required' => false,
                'label' => 'le nom de la sortie contient : ',
                'attr' => [
                    'placeholder' => '  search',
                ]
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'required' => false

            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'required' => false

            ])
            ->add('Rechercher', SubmitType::class, [
                'attr' => ['class' => 'Chercher']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Search::class
        ]);
    }
}
