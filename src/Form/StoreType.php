<?php

namespace App\Form;

use App\Entity\Store;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('siret', TextType::class, [
                "label" => "N° siret",
                "attr" => [
                    "placeholder" => "N° siret de l'organisme"
                ]
            ])

            ->add('name', TextType::class, [
                "label" => "Nom de l'organisme",
                "attr" => [
                    "placeholder" => "Nom de l'organisme"
                ]
            ])

            ->add('street', TextType::class, [
                "label" => "Numéro et nom de la rue",
                "required" => false,
                "attr" => [
                    "placeholder" => "Adresse de l'organisme"
                ]
            ])

            ->add('number', TextType::class, [
                "label" => "n°",
                "required" => false,
                "attr" => [
                    "placeholder" => "n° de rue"
                ]
            ])

            ->add('zip', NumberType::class, [
                "label" => "Code postal",
                "attr" => [
                    "placeholder" => "Code postal de l'organisme"
                ]
            ])

            ->add('city', TextType::class, [
                "label" => "Ville",
                "attr" => [
                    "placeholder" => "Ville où est situé l'organisme"
                ]
            ])

            ->add('phone', NumberType::class, [
                "label" => "Numéro de téléphone de l'organisme",
                "required" => false,
                "attr" => [
                    "placeholder" => "0123456789"
                ]
            ])

            ->add('schedules', TextareaType::class, [
                "label" => "Informations concernant les horaires d'ouverture de l'organisme",
                "required" => false,
                "attr" => [
                    "placeholder" => "ex. : Ouvert de 9h à 12h et de 13h à 18h du lundi au vendredi, de 9h à 13h le samedi"
                ]
            ])

            ->add('website', UrlType::class, [
                "label" => "Lien du site Internet de l'organisme",
                "required" => false,
                "attr" => [
                    "placeholder" => "Le lien URL site Internet"
                ]
            ])

            ->add('description', TextareaType::class, [
                "label" => "Description concernant l'organisme",
                "required" => false,
                "attr" => [
                    "placeholder" => "Parlez-nous un peu de vous et de votre organisme ici :). Cette description sera visible par les clients, sur votre page Boutique."
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Store::class,
        ]);
    }
}
