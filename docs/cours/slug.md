# Mise en place du slug 



###  A qoui sert il ?

- Mettre en place des Url lisibles est propre 
- DOC RAPPEL -> https://symfony.com/doc/5.4/components/string.html
- DOC Video => kourou O'Clock preparee par Jean Baptiste 

### Comment le mettre en place 

- `Mettre en place la nouvelle propriete`
  
- Il faut creer une proprieté  slug dans notre entité (product,store, ou category par exemple )
 
```php
    - bin/console make:entity :
       - propriete -> slug
       - string -> 255
       - nullable -> yes
```

- realiser : le make: migration ->  soit bin/console ma:mi
- realiser le binj/console do:mi:mi

- Se mettre dans les fixtures 
- En y ajoutant la generation du slug 

```php
  $product->setSlug('');
```

- Dans synfony il existe un service `sluggerInterface`, on recuppere ce service grâce à l'injection de dependance 
- 
- on va lui donner un slug --> sous forme de chaine caractere 
  
  ```php
  $slug = slugger-> slug('chaine de caractere');
  ```
- il va nous renvoyer un chaine de caractere compatible avec l'url
  
### RetournonS dans notre fixture 

- Nous allons utiliser le service  `sluggerInterface` dans notre fixture, pour mettre en place notre Url et il faudra executer le fixtures pour mettre a jours nos données
- Il faut mettre en place dans notre fixture un constructor 
- Ne pa oublier le use sluggerInterface

```php
class AppFixtures extends Fixture
{

    private $slugger
/**
 * 
 */ 
 public function__constructor(SluggerInterface $sluggerInterface)
 {
    $this->slugger = $sluggerInterface;
 }
    // TODO generation du slugg

  $slug =$this->slugger->slug($product->getProduct()); -> //mettre la chaine de caractere correspondant dans l url
  $product->setSlug($slug ); -> // ici on fourni le slug 

  }
  
```

- Ne pas oublier de mettre a jour la bdd :
- bin/console do:mi:mi
- bin/console d:f:l -n 

### Allons dans le controller sur la route show + id d'un store par exemle

- Creer une deuxieme route pour eviter la casse est tester le code dans un premier temps

```php
 /**
     * @Route("/show/{slug}", name="app_show_slug", requirements={"slug"="\.+ metre une regex"},methods={"GET"})
     */
    public function showSlug($lug ou Product $product=null) // param converter, Store $store): Response
    {
        // Product $product=null permet d'economiser un findBy
        $product = $productRepository->findBy(["slug"=>$slug]);
        dd($product); // pour verifier que tout fonctionne
        return $this->render('store/show.html.twig', [
            'store' => $store,
        ]);
    }
```

- Une fois tester il faut mettre en place le slug dans les differentes routes 
- en realisant une injection de dependance exemple :

```php
public function new(Request $request, ProductRepository $productRepository, StoreRepository $storeRepository, UserRepository $userRepository, SluggerInterface $sluggerInterface): Response
```

et le rappeller dans les routes utiles :

```php
$slug =$this->slugger->slug($product->getProduct());
```

### Attention :

- sur la route EDIT   vue qu'il y a une modification il faudra prevoir une conditions
- si ancien produit est different du nouveau produit  alors on renvoi a nouveau :
- $slug =$this->slugger->slug($product->getProduct());


### ON peut parametrer le comportement du slug 

- Exemple nous pouvons retourner un resultat tout  en miniscule via le parametrage de notre application , mais nous n'allons pas modifier tout le code, nous pouvons encapsuler notre Sluginterface en creant notre propre service de slug 
---

 # Creation de notre service SLUG

- DOC RAPPEL => https://symfony.com/doc/current/service_container.html
- DOC RAPPEL => https://zestedesavoir.com/

- Comme un service n'est q'une classe, il suffit de creer un fichier Service en generale dans le  `src` .
- La seule convention à respecter, de façon générale dans Symfony, c'est de mettre notre classe dans un namespace correspondant au dossier où est le fichier.

`Exemple`
```php


namespace App\Service;
use Symfony\Component\String\Slugger\SluggerInterface;
class MySlugger
{
  private $slugger;
  /**
   * constructor
   * 
   */
   public function ___construct(SluggerInterface $sulggerInterface)
   {
    $this->slugger = $sluggerInterface;
   }
  /**
   * generer un slug a partir d'une chaine
   * 
   * @param string $str
   */
   public function slug(string $str)
   {
      return $this->slugger->slug($str);
   }
}

```

### Utilisons notre slugger dans notre code 

- Il faut realiser l'injection de dependance dans notre code 

```php
public function new(Request $request, ProductRepository $productRepository, StoreRepository $storeRepository, UserRepository $userRepository, `MySlugger $myslugger`): Response
```

### Maintenant mofidions nos fixtures :

- mettre dans le construct :
  
```php
public function__constructor(MySlugger $slugger)
```

- Il faut vérifier en relançant nos fixtures  
- Verifier le fonctionnement du site

### parametrons pour mettre en minuscule  dans notre service 

- Dans notre service on peut activer ou desactiver la mise en minuscule
- Pour cela il faut : 
  
  - creer un nouvelle propriete en private dans notre slug
  - Realiser un condition pour l'activer ou le desactiver  -> si le lower est actif alors active les minuscules 

``` php
namespace App\Service;
use Symfony\Component\String\Slugger\SluggerInterface;
class MySlugger
{
  private $slugger;
  // active ou desactive true ou false grace à la condition qui fait la verification

  private $lower= false; 
  /**
   * constructor
   * 
   */
   public function ___construct(SluggerInterface $sulggerInterface)
   {
    $this->slugger = $sluggerInterface;
   }
  /**
   * generer un slug a partir d'une chaine
   * 
   * @param string $str
   */
   public function slug(string $str)
   {
        if ($this->lower){
            return $this->slugger->slug($str)->lower();
        } else {
            return $this->slugger->slug($str);
        }
    }
}

```

- Verifions  a nouveau la bdd, le fonctionnement du code 
- Ce service permet d'activer ou désactiver la chaine de caratere en miniscule  

### Maintenant parametrons le service dans le fichier .env

```yaml
###> MySlugger ###>
To_LOWER=true;
###> MySlugger ###>
```

- IL y a 2 étapes à realiser :
  - Parametrer le service dans `config/service.yaml`
  - Faire  la lecture du fichier `.env`depuis la configuration du `config/service.yaml`

### Allons dans notre `config/service.yaml`

``` yaml
# On donne le FQCN de notre service
    App\Service\MySlugger:
        # On précise qu'il y a des arguments à fournir
        arguments:
            # On donne le nom de l'argument et sa valeur
            # on lit la valeur de TO_LOWER dans le fichier .env
            # on précise que la valeur doit être tranformé en bool à true ou false 
            # par defaut si une autre valeur est mise il sera a false 
            $toLower: 'true'
``` 

### Maintenant il faut fournir cet argument toLower direction notre service 

``` php
namespace App\Service;
use Symfony\Component\String\Slugger\SluggerInterface;
class MySlugger
{
  private $slugger;
  // active ou desactive true ou false grace à la condition qui fait la verification

  private $lower= false; 
  /**
   * constructor
   * @param boolean $toLower argument venant du service.yaml
   */
  //Venir parametrer manuellement l'argument toLower configurer dans le service.yaml
   public function ___construct(SluggerInterface $sulggerInterface, $toLower)
   {
    $this->slugger = $sluggerInterface;
    $this->Lower=$toLower;
    // relancer les fixtures  pour verifier le boolean 
    // va lire le fichier construct des fixtures avec MySlugger-> va lire le fichier service construct avec le sluggerInterface et l'argument toLower-> va lire l'argument du service.yaml qui lui fournit une valeur a true -> et va lire le dd($toLower)qui est a true ;
    dd($toLower);
   }
  /**
   * generer un slug a partir d'une chaine
   * 
   * @param string $str
   */
   public function slug(string $str)
   {
        if ($this->lower){
            return $this->slugger->slug($str)->lower();
        } else {
            return $this->slugger->slug($str);
        }
    }
}
```
- le service est parametrer depuis le fichier de `config/service.yaml` 


### Maintenant il faut maintenant configurer le fichier .env

- Il faut dans le fichier `config/service.yaml` :

```php
# On donne le FQCN de notre service
    App\Service\MySlugger:
        # On précise qu'il y a des arguments à fournir
        arguments:
            # On donne le nom de l'argument et sa valeur
            # on lit la valeur de TO_LOWER dans le fichier .env
            # on précise que la valeur doit être tranformé en bool
            $toLower: '%env(bool:TO_LOWER)%'
```
- traduction du toLower => tu vas dans le fichier env -> me lire le boolean qui est = TO_LOWER=true