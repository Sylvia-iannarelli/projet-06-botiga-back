# A l'installation

## Dans le projet

- Créer un fichier `.env.local` avec les infos persos pour DATABASE_URL (cf. modèle .env)

`DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"`

## Informations à modifier dans le .env.local
  - `app` (après mysql://) : correspond au nom d'utilisateur
  - `!ChangeMe!` : correspond au mot de passe de l'utilisateur
  - `app` (après 3306/) : correspond au nom de la base de données
  - `8` (après serverVersion=) : correspond à la version de la BDD. Exemple : mariadb-10.3.25 dans notre cas

## Dans le terminal

- `composer update` // *pour installer les dépendances du projet*
- `php bin/console doctrine:database:create` // *pour créer la base de données correspondant aux informations renseignées dans le fichier* `.env.local`
- `php bin/console doctrine:migrations:migrate` // *pour appliquer les différentes migrations du projet (création de tables de BDD, liaisons, etc...)*
- `php bin/console doctrine:fixtures:load` // *pour charger les fausses données (fixtures) dans la base de données*
- `php -S 0.0.0.0:8000 -t public` // *pour lancer un serveur local (localhost:8000 dans l'URL pour y accéder)*
# projet-06-botiga-back
