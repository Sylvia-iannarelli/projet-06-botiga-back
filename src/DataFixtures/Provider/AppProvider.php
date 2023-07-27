<?php 

namespace App\DataFixtures\Provider;

class AppProvider{
    private $products = [
        'Oeuf',
        'Beurre',
        'Lait',
        'Fromage',
        'Yaourt nature',
        'Yaourt aux fruits',
        'Crềme fraîche',
        'Pain blanc',
        'Pain aux céréales',
        'Pâtes',
        'Farine de blé',
        'Farine de sarrazin',
        'Farine d\'orge',
        'Miel',
        'Confiture de fraise',
        'Confiture d\'abricot',
        'Confiture de figue',
        'Compote de pomme',
        'Compote de pêche',
        'Pâtes de fuits',
        'Artichaut',
        'Asperge',
        'Aubergine',
        'Betterave',
        'Blette',
        'Brocoli',
        'Carotte',
        'Céleri',
        'Chou-fleur',
        'Chou blanc',
        'Chou rouge',
        'Chou vert',
        'Citrouille',
        'Concombre',
        'Courgette',
        'Épinard',
        'Fenouil',
        'Fève',
        'Haricot vert',
        'Laitue',
        'Feuille de chêne',
        'Navet',
        'Oignon',
        'Petit pois',
        'Poireau',
        'Poivron',
        'Pomme de terre',
        'Radis',
        'Tomate',
        'Ananas',
        'Avocat',
        'Banane',
        'Cassis',
        'Cerise',
        'Citron',
        'Fraise',
        'Kaki',
        'Kiwi',
        'Orange',
        'Poire',
        'Pomme',
        'Abricot',
        'Clémentine',
        'Mûre',
        'Myrtille',
        'Groseille',
        'Coing',
        'Figue',
        'Framboise',
        'Melon',
        'Mandarine',
        'Orange',
        'Pamplemousse',
        'Mirabelle',
        'Noix',
        'Châtaigne',
        'Amande',
        'Pêche',
        'Prune',
        'Raisin blanc',
        'Raisin noir',
        'Boeuf',
        'Agneau',
        'Lapin',
        'Porc',
        'Jambon',
        'Saucisson',
        'Terrine',
        'Poulet',
        'Poule',
        'Pintade',
        'Dinde',
        'Canard',
        'Caille',
        'Vin blanc',
        'Vin rouge',
        'Bière',
        'Jus de fruits',
        'Sirop',
        'Liqueur',
        'Thym',
        'Romarin',
        'Persil',
        'Basilic',
        'Ciboulette',
        'Coriandre',
        'Menthe',
    ];

    private $categories = [
        'Fruits, légumes et plantes aromatiques',
        'Fromage et produits laitiers',
        'Viandes et charcuterie',
        'Volaille et oeufs',
        'Poisson et crustacés',
        'Vin et boissons',
        'Boulangerie et produits céréaliers',
        'Miels et produits de la ruche',
        'Confiseries',
        'Autres produits',
    ];

    /**
     * Obtenir un produit au hasard
     * 
     * @return string nom d'un produit
     */
    public function productName(){
        return $this->products[array_rand($this->products)];
    }

    /**
     * Obtenir un tableau de catégories
     * 
     * @return array categories
     */
    public function categoryList(){
        return $this->categories;
    }
}