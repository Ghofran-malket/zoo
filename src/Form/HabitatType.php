<?php

namespace App\Form;

use App\Entity\Habitats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabitatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Habitas Name',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('images', FileType::class, [
                'label' => 'Images (PNG, JPG)',
                'multiple' => true,  // Permettre de télécharger plusieurs fichiers
                'mapped' => false,   // Si ce champ n'est pas mappé à une propriété
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitats::class,
        ]);
    }
}
