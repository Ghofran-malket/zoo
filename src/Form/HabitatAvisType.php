<?php

namespace App\Form;

use App\Entity\Habitats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabitatAvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vet_opinion', TextType::class, [
                'label' => 'Veterinary opinion',
            ])
            ->add('need_improved',ChoiceType::class, [
                'label' => 'Is vet opinion approved?',
                'choices'  => [
                    'Yes' => true,
                    'No' => false,
                ],
                'expanded' => false, // If true, it renders radio buttons. If false, it renders a dropdown.
                'multiple' => false,
                'attr' => [
                    'class' => 'rounded'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitats::class,
        ]);
    }
}
