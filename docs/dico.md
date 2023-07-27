 Dictionnaire de données

## Utilisateur (`user`)

|Champ|Type|Spécificités|Description|Question Team
|-|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de notre utilisateur|
|firstname|VARCHAR(64)|NOT NULL|Le prénom de l'utilisateur|
|lastname|VARCHAR(64)|NOT NULL|Le nom de l'utilisateur|
|email|VARCHAR(128)|NOT NULL|L'adresse e-mail de l'utilisateur|
|password|VARCHAR(32)|NOT NULL|Le mot de passe de l'utilisateur|
|role|VARCHAR(32)|NOT NULL, DEFAULT ROLE_USER|Le rôle de l'utilisateur|
|connected|BOOL|NOT NULL, DEFAULT FALSE|Le statut de connexion de l'utilisateur|
|created_at|DATETIME_IMMUTABLE|NOT NULL, DEFAULT CURRENT_DATETIME_IMMUTABLE|La date de création du compte de l'utilisateur|
|updated_at|DATETIME_IMMUTABLE|NULL|La date de la dernière mise à jour du compte utilisateur|
|producerEntity_id|ENTITY|FOREIGN KEY|Identifiant de l'entité productrice|A peaufiner|

## Producteur (`store`)

|Champ|Type|Spécificités|Description|Question Team
|-|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de l'organisme|
|siret|VARCHAR(30)|NOT NULL|Le numéro de SIRET de l'organisme|
|name|VARCHAR(180)|NULL|Le nom de l'organisme|
|street|VARCHAR(255)|NULL|La rue de l'organisme|
|number|VARCHAR(5)|NULL|Le numéro de rue de l'organisme|
|zip|VARCHAR(5)|NULL|Le code postal de l'organisme|A peaufiner dans le form ?|
|city|VARCHAR(50)|NULL|La ville de l'organisme|
|phone|VARCHAR(20)|NULL|Le numéro de téléphone de l'organisme|
|schedules|VARCHAR(255)|NULL|Les horaires d'ouverture de l'organisme|
|website|VARCHAR(255)|NULL|Le site web de l'organisme|
|description|VARCHAR(255)|NULL|La description de l'organisme|
|picture|TEXT|NULL|Le/les images de l'organisme|
|heartLike|INT|NULL|Le compteur de like de l'organisme|
|created_at|DATETIME_IMMUTABLE|NOT NULL, DEFAULT CURRENT_DATETIME_IMMUTABLE|La date de création du compte de l'organisme|
|updated_at|DATETIME_IMMUTABLE|NULL|La date de la dernière mise à jour de l'organisme|

## Produit (`product`)

|Champ|Type|Spécificités|Description|Question Team
|-|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant du produit|
|name|VARCHAR(128)|NOT NULL|Le nom du produit|
|description|VARCHAR(255)|NOT NULL|La description du produit|
|price|INT|NOT NULL|Le prix du produit|
|vatRate|INT|NOT NULL|Le taux de TVA d'un produit|
|unitOfMeasurement|VARCHAR(64)|NOT NULL|L'unité de mesure d'un produit|Exemple : litre, kilo, lot, unité|
|pricePerUnit|INT|NOT NULL|Le prix d'une unité de mesure|
|stock|INT|NOT NULL|Le stock disponible du produit|
|picture|VARCHAR(255)|NULL|L'image du produit|
|heartLike|INT|NULL|Le compteur de like de du produit|
|created_at|DATETIME_IMMUTABLE|NOT NULL, DEFAULT CURRENT_DATETIME_IMMUTABLE|La date de création du produit|
|updated_at|DATETIME_IMMUTABLE|NULL|La date de la dernière mise à jour du produit|

## Catégorie (`category`)

|Champ|Type|Spécificités|Description|Question Team
|-|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de la catégorie|
|name|VARCHAR(64)|NOT NULL|Le nom de la catégorie|
|description|VARCHAR(128)|NOT NULL|La description de la catégorie|
|picture|VARCHAR(128)|NOT NULL|L'image de la catégorie|
|created_at|DATETIME_IMMUTABLE|NOT NULL, DEFAULT CURRENT_DATETIME_IMMUTABLE|La date de création de la catégorie|
|updated_at|DATETIME_IMMUTABLE|NULL|La date de la dernière mise à jour de la catégorie|

## Paiement (`payment`)

|Champ|Type|Spécificités|Description|Question Team
|-|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant du paiement|
|cardholderName|VARCHAR(64)|NOT NULL|Le titulaire de la carte|
|numberCard|VARCHAR(16)|NOT NULL|Le numéro de la carte|
|expirationDate|DATE|NOT NULL|La date d'expiration de la carte|Type Datetime ou autre?
|secretCode|VARCHAR(3)|NOT NULL|Le code secret de la carte|A vérifier comment gérer cette donnée|
|valid|BOOL|NOT NULL|Si le paiement a été validé ou non|En lien avec la propriété statusPayment, de l'entité ORDER|
|created_at|DATETIME_IMMUTABLE|NOT NULL, DEFAULT CURRENT_DATETIME_IMMUTABLE|La date de création du paiement|

## Commande (`order`)

|Champ|Type|Spécificités|Description|Question Team
|-|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de la commande|
|orderPrice|INT|NOT NULL|Le prix de la commande|Int ou Float?
|quantity|INT|NOT NULL|La quantité d'articles total de la commande|
|statusPayment|BOOL|NOT NULL|Si le paiement a été validé ou non|En lien avec la propriété valid, de l'entité PAYMENT|
|created_at|DATETIME_IMMUTABLE|NOT NULL, DEFAULT CURRENT_DATETIME_IMMUTABLE|La date de création de la commande|
|updated_at|DATETIME_IMMUTABLE|NULL|La date de la dernière mise à jour de la commande|

## Statut commande (`statusOrder`)

|Champ|Type|Spécificités|Description|Question Team
|-|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant du statut de la commande|
|name|VARCHAR(64)|NOT NULL|Le nom du statut de la commande|Exemple : Acceptée, préparée, récupérée|
|created_at|DATETIME_IMMUTABLE|NOT NULL, DEFAULT CURRENT_DATETIME_IMMUTABLE|La date de création du statut|
|updated_at|DATETIME_IMMUTABLE|NULL|La date de la dernière mise à jour du statut|

## Ligne de commande (`orderLine`) - TABLE DE JOINTURE

|Champ|Type|Spécificités|Description|Question Team
|-|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de la ligne d'une commande|
|quantity|INT|NOT NULL|La quantité de produit pour une ligne de commande|
|created_at|DATETIME_IMMUTABLE|NOT NULL, DEFAULT CURRENT_DATETIME_IMMUTABLE|La date de création de la ligne d'une commande|
