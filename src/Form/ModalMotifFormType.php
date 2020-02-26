<?php

namespace App\Form;

use App\Entity\MotifAnnulation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModalMotifFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', EntityType::class,[
                'label' => 'Motif de l\'annulation',
                'class' => MotifAnnulation::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Choisir un motif',
                'attr' => [
                    'class' => 'form-control',
                    'hidden' => 'true'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotifAnnulation::class,
        ]);
    }
}
