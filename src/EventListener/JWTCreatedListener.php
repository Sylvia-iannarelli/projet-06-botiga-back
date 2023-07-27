<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

// Création de la class JWTCreatedListener, pour que le code fournit par la documentation puisse fonctionner
// https://symfony.com/bundles/LexikJWTAuthenticationBundle/current/2-data-customization.html#adding-custom-data-or-headers-to-the-jwt
class JWTCreatedListener
{
    
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $payload       = $event->getData();
        $payload['ip'] = $request->getClientIp();

        $event->setData($payload);

        $header        = $event->getHeader();
        $header['cty'] = 'JWT';

        $event->setHeader($header);
    }

}

