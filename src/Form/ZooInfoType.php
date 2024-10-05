<?php

namespace App\Form;

use App\Entity\Zoo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZooInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => false
            ])
            ->add('location', TextType::class, [
                'label' => 'Location',
                'required' => false
            ])
            ->add('price', TextType::class, [
                'label' => 'Price',
                'required' => false
            ])
            ->add('opening_time', TextType::class, [
                'label' => 'Description',
                'required' => false
            ])
            ->add('phone_number' ,TextType::class, [
                'label' => 'Phone number',
                'required' => false
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false
            ])
            ->add('facebook_link', TextType::class, [
                'label' => 'Facebook link',
                'required' => false
            ])
            ->add('twitter_link', TextType::class, [
                'label' => 'Twitter link',
                'required' => false
            ])
            ->add('tiktok_link', TextType::class, [
                'label' => 'Tiktok link',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zoo::class,
        ]);
    }
}
