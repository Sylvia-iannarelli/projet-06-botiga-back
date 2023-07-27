# Formulaire de connexion


### Documentation doc :

 - lien de la doc : https://symfony.com/doc/current/security.html

### Installez le composant Security en utilisant Composer :

- `composer require symfony/security-bundle` si cela a été fais en debut de projet 

### Créez une classe User pour représenter les utilisateurs de votre application. Vous pouvez le faire en utilisant la commande suivante :

- `php bin/console make:user`  Nous l'avons fait  fai en début de projet quand nous avons mis en place notre `UserEntity`
- Nous avons repondu aux questions pour definir les proprietés des utilisateurs, tel que le nom de l'utilisateur, l'addresse e-mail, le mot de passe.

### Générez le formulaire de connexion en utilisant la commande suivante :

- faire la commande : `php bin/console make:auth`
- Cela générera un formulaire de connexion avec toutes les fonctionnalités nécessaires, telles que la validation du nom d'utilisateur et du mot de passe, la gestion des erreurs, etc.

### Il faut créez une page de connexion dans notre application en ajoutant une route pour le formulaire de connexion. Par exemple :


```yaml
- // routes.yaml
app_login:
  path: /login
  controller: App\Controller\SecurityController::login

```

### Dans le contrôleur SecurityController, il faut implémentez les méthodes login() et logout() :

```php
<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // obtenir l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', 
        ['last_username' => $lastUsername, 
        'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
```

- La méthode login() affichera le formulaire de connexion et traitera les erreurs éventuelles. La méthode logout() gérera la déconnexion de l'utilisateur.

 <!-- TODO  a faire -->

 - Mettre en place `le security.yaml` : 
    - le sécurity
    - le providers
    - firewalls
    - doc => https://symfony.com/doc/current/security.html
  







