<?php

namespace App\Form;

use App\Entity\Payment;
use Doctrine\DBAL\Types\DatetimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cardholderName', TextType::class, [
                "label" => "Titulaire de la carte",
                "attr" => [
                    "placeholder" => "Titulaire de la carte"
                ]
            ]) 
            // ->add('expirationDate')

            //   ->add('expirationDate', DatetimeType::class, [
            //      "label" => "date validation commande",
            //      "attr" => [
            //          "placeholder" => "Mettre la date"
            //      ]
            //  ])
                       
            ->add('numberCard')
            ->add('secretCode')
            ->add('valid')
           ;
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
