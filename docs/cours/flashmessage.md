# FLASH MESSAGE

### RAPPEL DOC

- doc => https://symfony.com/doc/current/session.html#flash-messages

### A qoi servent - ils ?

- Le flash, ou message flash, est une fonctionnalité couramment utilisée dans les applications web pour afficher des messages temporaires à l'utilisateur après une action. Il s'agit généralement d'un court message qui informe l'utilisateur du résultat de son action (par exemple, `"Votre compte a été créé avec succès !"`, ou `"votre article a été creer avec succès !"`).


### mise en place du flash message :

Nous avons ajouté dans nos controller , ajoutez un message flash à la session en utilisant la méthode set() :

```php
$this->addFlash('success', 'Le formulaire a été envoyé avec succès !');
```

### dans le twig  il ya 2 étapes à réalisées:

- `Première Etape` :

    - Creation d'un fichier `_flash_message.html.twig ` a la racine du Dossier `template`
  
```php
  	{% for label, messages in app.flashes %}
		{% for message in messages %}
			<div class="alert alert-{{ label }} alert-dismissible fade show" role="alert"> {{ message }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	{% endfor %}
```

- `Deuxième étape :`

    - Mise en place d'un include dans les fichiers `index.html.twig`
```php
{{ include('_flash_messages.html.twig') }}
```  



