<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du lieu',
                'attr' => [
                    'placeholder' => 'Forêt',
                    'class' => 'form-control',
                ],
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue',
                'attr' => [
                    'placeholder' => 'Rue du chêne',
                    'class' => 'form-control',
                ],
            ])
            ->add('lattitude', NumberType::class, [
                'label' => 'lattitude',
                'attr' => [
                    'placeholder'=> 0.123456789,
                    'class' => 'form-control',
                ],
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'longitude',
                'attr' => [
                    'placeholder'=> 0.123456789,
                    'class' => 'form-control',
                ],
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'label' => 'Ville',
                'placeholder' => '--Ville--',
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
