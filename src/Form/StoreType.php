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
                "label" => "Numéro de SIRET",
                "attr" => [
                    "placeholder" => "Numéro de SIRET de l'organisme"
                ]
            ])

            ->add('name', TextType::class, [
                "label" => "Nom de l'organisme",
                "attr" => [
                    "placeholder" => "Nom de l'organisme"
                ]
            ])

            ->add('street', TextType::class, [
                "label" => "Nom de rue",
                "required" => false,
                "attr" => [
                    "placeholder" => "Nom de rue de l'organisme"
                ]
            ])

            ->add('number', TextType::class, [
                "label" => "Numéro de rue",
                "required" => false,
                "attr" => [
                    "placeholder" => "Numéro de rue de l'organisme"
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
                    "placeholder" => "Ville où est située l'organisme"
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
                "label" => "Informations concernant les horaires de l'organisme",
                "required" => false,
                "attr" => [
                    "placeholder" => "Les informations concernant les horaires de l'organisme (exemple: créneaux horaires et disponibilités sur la semaine)"
                ]
            ])

            ->add('website', UrlType::class, [
                "label" => "Lien de votre website",
                "required" => false,
                "attr" => [
                    "placeholder" => "Le lien URL du website de votre organisme (si il y a)"
                ]
            ])

            ->add('description', TextareaType::class, [
                "label" => "Description concernant votre organisme",
                "required" => false,
                "attr" => [
                    "placeholder" => "Parlez-nous un peu de vous et de votre organisme ici :).
Cette description sera visible par les clients, sur votre page Store."
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
