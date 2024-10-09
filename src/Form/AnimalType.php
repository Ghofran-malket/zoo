<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Habitats;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'name',
            ])
            ->add('race', TextType::class, [
                'label' => 'race',
            ])
            ->add('images', FileType::class, [
                'label' => 'Images (PNG, JPG)',
                'multiple' => true,  // Permettre de télécharger plusieurs fichiers
                'mapped' => false,   // Si ce champ n'est pas mappé à une propriété
                'required' => false,
            ])
            ->add('habitat_id', EntityType::class, [
                'class' => Habitats::class,
                'choice_label' => 'name', // Assuming the Habitat entity has a 'name' property
                'label' => 'Habitat',
                'attr' => ['class' => 'form-control'],
                'placeholder' => 'Choose a habitat',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
