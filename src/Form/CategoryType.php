<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('name')
            ->add('name', TextType::class, [
                "label" => "Catégorie",
                "attr" => [
                    "placeholder" => "Nom de la catégorie"
                ]
            ])

            // ->add('description')
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                "attr" => [
                    "placeholder" => "Description"]
            ])

            // ->add('picture')
            ->add('picture', UrlType::class, [
                'label' => 'Image',
                'help' => 'Une URL au format http:// ou https://',
                ]);

          
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
