# Installation de geocoder 

### A quoi sert-il ?
---


### DEFINITION:
---

-Il permet de mettre en place un service de d'adresse automatique avec symfony 


### Installation
---

- Pour installer un géocodeur, il y a deux choses que vous devez savoir :

- Quel fournisseur de géocodeur vous souhaitez utiliser?
- Quel client/adaptateur HTTP vous souhaitez utiliser.?


- Installez le package "geocoder" à l'aide de Composer en exécutant la commande suivante dans votre terminal :
  
### le fournisseur de geocoder
---
- Pour notre projet on souhaite utiliser comme fourniseur  Google Map
- - => DOC GITHUB : https://github.com/geocoder-php/Geocoder
- composer require geocoder-php/geo-coder en utilisant la doc packgiste
- => DOC DE PACKGISTE : https://packagist.org/providers/geocoder-php/provider-implementation
- => DOC GITUHB : `https://github.com/geocoder-php/google-maps-provider`
  `cles api`
- Toutes les demandes nécessitent une clé API valide, mais Google propose un niveau gratuit . Veuillez consulter cette page pour plus d'informations sur l'obtention d'une clé API .
- => DOC GOOGLE Cles API :https://developers.google.com/maps/documentation/geocoding/get-api-key?hl=fr


### Le client http Aquoi sert -il ?
---
- Le client HTTP permet de  communiquer avec le fournisseur de geocodage , de recuprer le resultat, de traiter les erreurs..
- notre client http correspondant a google Map est : guzzlehttp/guzzle
- => DOC Packagiste : https://packagist.org/packages/guzzlehttp/guzzle
- => DOC Client HTTP - Définition => https://www.techno-science.net/definition/636.html


### Configuration  de geocoder 

 - `Installez` le package "geocoder" à l'aide de Composer en exécutant la commande suivante dans votre terminal :
  
   `composer require geocoder-php/google-maps-provider guzzlehttp/guzzle`

- `Configurez` votre service dans le fichier de configuration services.yaml. Voici un exemple de configuration de service :
  
 # config/packages/geocoder.yaml
geocoder:
    providers:
        google_maps:
            type: google_maps
            api_key: VOTRE_CLE_API_GOOGLE_MAPS
    adapters:
        google_maps:
            guzzle: ~









https://adresse.data.gouv.fr/api-doc/adresse