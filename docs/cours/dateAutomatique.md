# Date Automatique :Stof Doctrine

 ### Bundle a utilser :

- composer require sto/doctrine-extensions-bundle
- Configurer stof_doctrine_extensions.yaml

```yaml

#  https://symfonycasts.com/screencast/symfony2-ep3/timestampable
stof_doctrine_extensions:
    default_locale: fr_FR
    orm:
        default:
            sluggable: true
            timestampable: true
            blameable: true
```

### Utiliser le trait TimestamableEntity au dessus de l'entité :

- `use TimestampableEntity;`
- `use Gedmo\Timestampable\Traits\TimestampableEntity;`
- Supprimmer les champs CreatedAt et UpdatedAt ainsi sue les getters et setters de l'entité
- Faire une migration  bin/console make:migration
- Appliquer la migration (do:mi:mi)
