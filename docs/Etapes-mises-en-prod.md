# Listing des étapes de mises en prod

*fiche récap pour détails* 
https://kourou.oclock.io/ressources/fiche-recap/deploiement-projet-sur-serveur-aws-ubuntu-procedure/

## Dans l'ordre réaliser les étapes suivantes.

- se connecter en ssh à la vm (commande dispo dans gestion serveur cloud kourou)
- créer une clé pour la connexion ssh pour la connexion github :https://docs.github.com/fr/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent
- une fois en place vous pouvez récupérer le repo : https://github.com/O-clock-Proton/S08-installation-serveur 
- installer le serveur via le script (attention modifiez les droits du fichier pour l'executer) `chmod u+x "nom du fichier"` pour les droits
- aller sur l'adresse http du serveur (voir lien dans gestion serveur cloud kourou) pour voir si le serveur marche bien

## Le serveur est en place à partir d'ici on met en place le projet symfo

- cloner le repo du projet dans www/html
- composer install --no-dev --optimize-autoloader (pour installer les dépendances de prod) la doc https://symfony.com/doc/current/deployment.html
- créer le .env.local avec tout ce qu'il faut 
- composer dump-env prod pour générer un .env optimisé
- APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
- installer la bdd create:database
- appliquer les migrations do:mi:mi

*A cette étape le site, fonctionne si vous allez sur l'url site/public, les autres routes bug et c'est dommage de devoir aller sur le dossier public pour que ça marche, vocii les solutions*

## Virtualhost

- Ouvrez le dossier "sites-available" d'Apache (généralement situé dans /etc/apache2/).
- Créez un nouveau fichier de configuration pour votre virtualhost en utilisant un nom significatif suivi de l'extension ".conf", par exemple "mondomaine.conf".
- exemple de config à mettre dans le fichier
```
<VirtualHost *:80>
    ServerName domain.tld
    ServerAlias www.domain.tld

    DocumentRoot /var/www/project/public
    <Directory /var/www/project/public>
        AllowOverride All
        Order Allow,Deny
        Allow from All
    </Directory>

    # uncomment the following lines if you install assets as symlinks
    # or run into problems when compiling LESS/Sass/CoffeeScript assets
    # <Directory /var/www/project>
    #     Options FollowSymlinks
    # </Directory>

    ErrorLog /var/log/apache2/project_error.log
    CustomLog /var/log/apache2/project_access.log combined
</VirtualHost>
```
- activer le fichier avec la commande : `sudo a2ensite tonsite.conf`
- redémarrez apache : `sudo service apache2 restart`
- Votre nom de domaine pointe maintenant vers votre dossier public, plus besoin d'aller sur /public pour voir le site ! 

## htaccess
- Pour finir, il n'y a plus qu'à mettre en place le htaccess : `composer require symfony/apache-pack --update-no-dev`