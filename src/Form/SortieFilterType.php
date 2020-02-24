<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isOrganisateur',     CheckboxType::class, [
                'label'    => 'Sortie dont je suis organisateur/trice'
            ])
            ->add('isInscrit',     CheckboxType::class, [
                'label'    => 'Sorties auquelles je suis inscrit/e'
            ])
            ->add('isNotInscrit',     CheckboxType::class, [
                'label'    => 'Sorties auquelles je ne suis pas inscrit/e'
            ])
            ->add('isClosed',     CheckboxType::class, [
                'label'    => 'Sorties passées'
            ])

            ->add('site',EntityType::class,[
                'class' => Site::class,
            ])
            ->add('nom', TextType::class, [
                'label' => 'le nom de la sortie contient : ',
                'attr' => [
                    'placeholder' => '  search',
                ]
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'widget' => 'single_text',

            ])
            ->add('heureFin', DateType::class, [
                'widget' => 'single_text',

            ])
        ->add('Rechercher', ButtonType::class, [
            'attr' => ['class' => 'Chercher'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
