<?php

namespace App\EventListener;

use App\Controller\OrderController;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

// Documentation pour référence
// 
class AuthenticationSuccessListener
{

    private Serializer $serializer;

    // Grâce à l'injection de dépendance de Symfony, je peux demander au framework un "outil" qu'il a référencé et m'enservir dans les méthodes de ma classe
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
    
    /**
    * @param AuthenticationSuccessEvent $event
    */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event )
    {
        
        $data = $event->getData();
        $user = $event->getUser();
        
        if (!$user instanceof User) {
            return;
        }
        
        // Je transforme mon objet User en un tableau, grâce au contexte 'user_show' je choisis d'afficher les propriétés appartenant au groupe
        $data['user'] = $this->serializer->normalize($user, null, [
            "groups" => ["user_show"]
        ]);

        // dd($data);

        $event->setData($data);

    }


}