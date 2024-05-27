<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class UserType extends AbstractType
{
    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // le builder permet de nous aider à construire les champs du formulaire en mettant en place les type de champs et rendra le controleur plus dynamique
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use($options) {

            // Récupération du formulaire
            $form = $event->getForm();

            // On va appliquer des conditions selon le rôle de l'utilisateur connecté ou pas connecté

            // S'il y a un utilisateur connecté
            if($user = $this->security->getUser()) {

                if($user->getRoles()==["ROLE_PRODUCER"]) {

                    $form
                    ->add('firstname', TextType::class, [
                        'label'=> 'Votre prénom',
                    ])

                    ->add('lastname', TextType::class, [
                        'label'=> 'Votre nom',
                    ])

                    ->add('email', EmailType::class, [
                        'label' => 'Votre email',
                    ])

                    ->add('phone', TextType::class, [
                        'label'=> 'Votre numéro de téléphone',
                        'invalid_message' => 'Veuillez entrer un numéro valide',
                    ]);

                } else if ($user->getRoles()==["ROLE_ADMIN"]) {

                    $form
                    ->add('firstname', TextType::class, [
                        'label'=> 'Votre prénom',
                    ])

                    ->add('lastname', TextType::class, [
                        'label'=> 'Votre nom',
                    ])

                    ->add('email', EmailType::class, [
                        'label' => 'Votre email',

                    ])

                    ->add('phone', TextType::class, [
                        'label'=> 'Votre numéro de téléphone',
                        'invalid_message' => 'Veuillez entrer un numéro valide',
                    ])

                    ->add('roles', ChoiceType::class, [
                        "label" => "Privilèges",
                        "choices" => [
                            "Producteur" => "ROLE_PRODUCER",
                            "Administrateur" => "ROLE_ADMIN",
                            "Utilisateur" => "ROLE_USER"
                        ],
                        "multiple" => true,
                        "expanded" => true
                    ]);
                }

            } else {

                    $form
                    ->add('firstname', TextType::class, [
                        'label'=> 'Votre prénom',
                    ])
    
                    ->add('lastname', TextType::class, [
                        'label'=> 'Votre nom',
                    ])
    
                    ->add('email', EmailType::class, [
                        'label' => 'Votre email',
    
                    ])
    
                    ->add('phone', TextType::class, [
                        'label'=> 'Votre numéro de téléphone',
                        'invalid_message' => 'Veuillez entrer un numéro valide',
                    ])
    
                    ->add('password', RepeatedType::class, [
                        // le type champ à répéter
                        'type' => PasswordType::class,
                        // message en cas d'erreur
                        'invalid_message' => 'Les mots de passe ne correspondent pas.',
                        // options pour les 2 champs (si besoin, pas nécessaire pour nous)
                        'options' => [
                            'attr' => ['class' => 'password-field'],
                        ],
                        'required' => true,
                        // options pour le champ 1
                        'first_options'  => [
                            'label' => 'Mot de passe',
                            'help' => 'Votre mot de passe doit avoir une longueur de 8 à 20 caractères et contenir des lettres et des nombres (espace, caractères spéciaux ou emoji non autorisés).',
                            // contraintes sur le champ de formulaire
                            'constraints' => new NotBlank(),
                        ],
                        // options pour le champ 2
                        'second_options' => ['label' => 'Confirmer le mot passe']
                    ]);
                }
        });
    }
    


    /**
     * Ici, on configure les options du form en lui-même
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //TODO OPTION A METTRE EN PLACE  PROTECTION DU FORM
            //https://symfony.com/doc/5.4/security/csrf.html
            'data_class' => User::class,
            // // équivaut à Twig {'attr': {'novalidate': 'novalidate'}}
            // 'attr' => [
            //     'novalidate' => 'novalidate',
            // ]


             // active/désactive la protection CSRF pour ce formulaire
             'csrf_protection' => true,
             // le nom du champ HTML caché qui stocke le jeton
             'csrf_field_name' => '_token',
            // une chaîne arbitraire utilisée pour générer la valeur du jeton
        // utiliser une chaîne différente pour chaque formulaire améliore sa sécurité
            'csrf_token_id'   => 'task_item',
        ]);
    }

}
