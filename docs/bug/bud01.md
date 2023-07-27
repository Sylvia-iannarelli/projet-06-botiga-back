### ERREURS 

### An exception occurred while executing a query: SQLSTATE[23000]: Integrity constraint  
violation: 1048 Column 'email' cannot be null 
SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'email' cannot be null
---
J'avais mis dans ma datafixture un `user->getEmail`  => `user->setEmail` 


---
#### Notice: Array to string conversion
https://github.com/symfony/symfony/issues/30872

- Je n'avais pas corriger mon erreur Email dans mes fixtures car je ne voyais pas l'erreur 
- En ajoutant  manuellement mes elements a mon formulaire cela ma creer cette errreur qu'il narrivais pas a à convertir mon tableau 
- Quand j'ai compris mon erreur avec l'email en lançant ma datafixture avec : `bin/console d:f:l -n`
J'avais vue que j'avais aussi une erreur sur  `user->getRole`  =>  `user->setRole`
Mes fixtures fonctionnes maintenant

 --- 
 ### configuration formulaire du phone
 An exception occurred while executing a query: SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column 'phone' at row 1

 - `->add('phone', TextType::class, [
                'label'=> 'Votre telephone', 
            ])`
- mes recherche : https://stackoverflow.com/questions/31588267/symfony-validate-telephone-in-form-field

 - Solution Une : ajout de la lenght 10 à 20  dans la propriete phone car j ajoute avec le pluging google FakeFiller  mes données au hasard phone  anglais 
  
 - Solution : j'aurais pu configurer le form  avec le : `TelType Field` et mettre une assert annotation @MisdAssert\PhoneNumber() dans l'entité    

 - Solution : Je peux mettre aussi un message dans le `add` de `phone`
   `'invalid_message' => 'That is not a valid issue number'` 
