<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieCancelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',IntegerType::class)
            ->add('nom',TextType::class,[
                'disabled' => 'true'
            ])
            ->add('dateHeureDebut', DateType::class, [
                'widget' => 'single_text',
                'disabled' => 'true'
            ])
            ->add('dateLimitInscription', DateType::class, [
                'widget' => 'single_text',
                'disabled' => 'true'
            ])
            ->add('lieu',TextType::class,[
                'disabled' => 'true'
            ])
            ->add('site', TextType::class, [
                'label' => 'Ville',
                'disabled' => 'true'])
            ->add('infosSortie',TextareaType::class,[
                'label' => 'Motif de l\'annulation',
                'required' => 'true'

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
