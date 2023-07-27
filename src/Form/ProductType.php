<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Store;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom du produit",
                "attr" => [
                    "placeholder" => "Nom"
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description du produit",
                "attr" => [
                    "placeholder" => "Description"
                ]
            ])
            ->add('price', NumberType::class, [
                "label" => "Prix du produit (en €)",
                "attr" => [
                    "placeholder" => "Prix"
                ]
            ])
            ->add('vatRate', ChoiceType::class, [
                "label" => "Taux de tva appliqué",
                "choices" => [
                    "5,5%" => "5,5%",
                    "10%" => "10%",
                    "20%" => "20%"
                ],
                "expanded" => true
            ])
            ->add('unitOfMeasurement', ChoiceType::class, [
                "label" => "Unité de mesure",
                "choices" => [
                    "Kilo" => "Kilo",
                    "Litre" => "Litre",
                    "Pièce" => "Pièce",
                    "Lot" => "Lot"
                ],
                "expanded" => true
            ])
            ->add('pricePerUnit', NumberType::class, [
                "label" => "Prix par unité (en €)",
                "attr" => [
                    "placeholder" => "Prix par unité"
                ]
            ])
            ->add('stock', NumberType::class, [
                "label" => "Nombre d'unités de produits disponibles",
                "attr" => [
                    "placeholder" => "Nombre"
                ]
            ])
            ->add('picture', UrlType::class, [
                "label" => "Photo du produit",
                "attr" => [
                    "placeholder" => "Lien URL de l'image"
                ]
            ])
            // // TODO : à corriger pour que ce soit automatique (selon store_id du producteur connecté)
            // ->add('store', EntityType::class,[
            //     "label" => "Producteur",
            //     "class" => Store::class,
            //     "multiple" => false,
            // ])
            ->add('category', EntityType::class,[
                "label" => "Catégorie",
                "class" => Category::class,
                "multiple" => false,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
