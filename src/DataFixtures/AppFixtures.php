<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Store;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Payment;
use App\Repository\UserRepository;
use DateTimeImmutable;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // ! FIXTURE USER
        // ! Gestion des infos d'un admin sur le producteur et le comsommateur

        $userAdmin = new User();

        // definition des propriétes a générer
        $userAdmin->setFirstname('So Ven');
        $userAdmin->setLastname('Mao');
        $userAdmin->setEmail('admin@oclock.io');
        $userAdmin->setPhone('1234567891');
        $userAdmin->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $userAdmin->setRoles(['ROLE_ADMIN']);

        // donner a doctrine
        $manager->persist($userAdmin);

        // ! FIXTURE USER 1
        $user = new User();

        $user->setFirstname('Karine');
        $user->setLastname('Schobert');
        $user->setEmail('karine@oclock.io');
        $user->setPhone('telephone');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 1
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("Ferme de la motte Giron");
        $store->setStreet("Route de Corcelles");
        $store->setNumber("");
        $store->setZip("21000");
        $store->setCity("Dijon");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("https://www.bienvenue-a-la-ferme.com/bourgognefranchecomte/cote-d-or/dijon/ferme/ferme-de-la-motte-giron/595605");
        $store->setDescription("Vente à la ferme directement : Lait, fromages, crème, œufs.");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 1
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(15);
        $order->setQuantity(2);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 1

        $category = new Category();
        $category->setName("Produit laitier");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 1
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Lait (1 L)");
        $product->setDescription("Pellentesque lorem arcu, consectetur quis eros vitae, maximus elementum augue.");
        $product->setPrice(2.10);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Litre");
        $product->setPricePerUnit(2.10);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2017/01/18/15/23/milk-can-1990072_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);
        /******************************************************************************************************************/

        // ! FIXTURE USER 2
        $user = new User();

        $user->setFirstname('Sylvia');
        $user->setLastname('iannarelli');
        $user->setEmail('sylvia@oclock.io');
        $user->setPhone('telephone');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 2
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("Ferme de la Pérouse");
        $store->setStreet("Chem. de la Pérouse");
        $store->setNumber("");
        $store->setZip("21370");
        $store->setCity("Plombières-lès-Dijon");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("pas de site ");
        $store->setDescription("Vente de produit frais");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 2
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(25);
        $order->setQuantity(40);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 2

        $category = new Category();
        $category->setName("Fruits et légumes");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 2
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Haricots verts (500 g)");
        $product->setDescription("Produit d'excellente qualité mis sous vide pour une meilleure conservation");
        $product->setPrice(6.90);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Kilo");
        $product->setPricePerUnit(13.80);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2022/07/04/10/41/beans-7300846_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);
        /******************************************************************************************************************/

        // ! FIXTURE USER 3
        $user = new User();

        $user->setFirstname('Basil');
        $user->setLastname('Gaudion');
        $user->setEmail('basil@oclock.io');
        $user->setPhone('telephone');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 3
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("Ferme de Beaumotte");
        $store->setStreet("Ferme de Beaumotte");
        $store->setNumber("");
        $store->setZip("21410");
        $store->setCity("Agey");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("pas de site ");
        $store->setDescription("Vente de produit frais");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 3
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(50);
        $order->setQuantity(5);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 3

        $category = new Category();
        $category->setName("Viande et charcuterie");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 3
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Cochon farci à la broche (250 g)");
        $product->setDescription("Produit d'excellente qualité mis sous vide pour une meilleure conservation");
        $product->setPrice(9.88);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Kilo");
        $product->setPricePerUnit(39.5);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2016/10/04/08/06/spit-roast-1713752_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);
        /******************************************************************************************************************/

        // ! FIXTURE USER 4
        $user = new User();

        $user->setFirstname('Elodie');
        $user->setLastname('Frappat');
        $user->setEmail('elodie@oclock.io');
        $user->setPhone('12345678');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 4
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("Ferme d'Etaules");
        $store->setStreet("Rue Jean Nibet");
        $store->setNumber("");
        $store->setZip("21121");
        $store->setCity("Etaules");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("pas de site ");
        $store->setDescription("Vente de produit frais");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 4
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(50);
        $order->setQuantity(5);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 4

        $category = new Category();
        $category->setName("Volaille et œufs");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 4
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Dinde entière (environ 5 Kg)");
        $product->setDescription("Pellentesque lorem arcu, consectetur quis eros vitae, maximus elementum augue.");
        $product->setPrice(65);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Kilo");
        $product->setPricePerUnit(13);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2013/11/26/20/01/turkey-218742_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);
        /******************************************************************************************************************/
        // ! FIXTURE USER 5
        $user = new User();

        $user->setFirstname('David');
        $user->setLastname('Oclock');
        $user->setEmail('david@oclock.io');
        $user->setPhone('12345678');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 5
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("Ferme de la Goutte d'Or");
        $store->setStreet("Grande Rue");
        $store->setNumber("");
        $store->setZip("21220");
        $store->setCity("Epernay-sous-Gevrais");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("pas se site");
        $store->setDescription("Vente de produits faits maison, farine, huiles, légumineuses de qualité supérieure");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 5
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(100);
        $order->setQuantity(15);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 5

        $category = new Category();
        $category->setName("Produits céréaliers");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 5
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Farine de blé T55 (1 Kg)");
        $product->setDescription("Farine faite maison");
        $product->setPrice(1.95);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Kilo");
        $product->setPricePerUnit(1.95);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2018/01/22/01/09/food-3097920_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);
        /******************************************************************************************************************/
        // ! FIXTURE USER 6
        $user = new User();

        $user->setFirstname('Caroline');
        $user->setLastname('Dunkerque');
        $user->setEmail('caroline@oclock.io');
        $user->setPhone('12345678');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 6
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("Ferme du Pontot");
        $store->setStreet("ferme du pontot");
        $store->setNumber("");
        $store->setZip("21220");
        $store->setCity("Gevrey-Chambertin");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("https://www.gaec-du-pontot.com/");
        $store->setDescription("Vente de truites d'élevage");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 6
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(30);
        $order->setQuantity(3);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 6

        $category = new Category();
        $category->setName("Poisson et crustacés");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 6
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Truites (environ 500 g)");
        $product->setDescription("Lot De 2 Truites Arc-en-ciel");
        $product->setPrice(18.90);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Kilo");
        $product->setPricePerUnit(37.80);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2017/02/12/15/58/trout-2060370_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);
        /******************************************************************************************************************/
        // ! FIXTURE USER 7
        $user = new User();

        $user->setFirstname('Franck');
        $user->setLastname('Sylvestar');
        $user->setEmail('franck@oclock.io');
        $user->setPhone('12345678');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 7
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("L'Escargot Dijonnais");
        $store->setStreet("Chem. de la Sans Fond");
        $store->setNumber("");
        $store->setZip("21600");
        $store->setCity("Fénay");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("http://www.escargot-dijonnais.fr/ ");
        $store->setDescription("Vente d'escagot et de verrines");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 7
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(30);
        $order->setQuantity(3);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 7

        $category = new Category();
        $category->setName("Autres produits");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 7
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Escargots (environ 500 g)");
        $product->setDescription("Une douzaine d'escargots préparés au beurre à l'ail et au persil.");
        $product->setPrice(13.75);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Kilo");
        $product->setPricePerUnit(27.50);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2012/11/08/14/46/snail-65358_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);

        /******************************************************************************************************************/
        // ! FIXTURE USER 8
        $user = new User();

        $user->setFirstname('Lionnel');
        $user->setLastname('Desantos');
        $user->setEmail('lionnel@oclock.io');
        $user->setPhone('12345678');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 8
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("La ferme du trembloy");
        $store->setStreet("Le trembloy");
        $store->setNumber("");
        $store->setZip("21540");
        $store->setCity("Remilly-en-Montagne");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("https://www.lafermedutrembloy.fr/");
        $store->setDescription("Vente de miel et produits de la ruche, de qualité supérieure");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 8
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(30);
        $order->setQuantity(3);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 8

        $category = new Category();
        $category->setName("Miel et produits de la ruche");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 8
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Miel d'Acacia (500 g)");
        $product->setDescription("Pellentesque lorem arcu, consectetur quis eros vitae, maximus elementum augue.");
        $product->setPrice(14.65);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Kilo");
        $product->setPricePerUnit(29.30);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2017/05/11/12/24/dandelion-2304006_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);
        /******************************************************************************************************************/
        // ! FIXTURE USER 9
        $user = new User();

        $user->setFirstname('Bruce');
        $user->setLastname('Stylice');
        $user->setEmail('bruce@oclock.io');
        $user->setPhone('12345678');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 9
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("EARL FERME DE LA LIMAYE");
        $store->setStreet("impasse de la Limaye");
        $store->setNumber("525");
        $store->setZip("71130");
        $store->setCity("Neuvy-Grandchamp");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("https://fermedelalimaye.wixsite.com/neuvy");
        $store->setDescription("Vente de produits de la ferme d'excellente qualité");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 9
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(30);
        $order->setQuantity(3);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 9

        $category = new Category();
        $category->setName("Confiseries");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 9
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Bonbons aux fruits (50 g)");
        $product->setDescription("Petits bonbons fabriqués de manière artisanale.");
        $product->setPrice(2.80);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Kilo");
        $product->setPricePerUnit(56);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2022/02/26/21/35/candies-7036390_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);
        /******************************************************************************************************************/
        // ! FIXTURE USER 10
        $user = new User();

        $user->setFirstname('François');
        $user->setLastname('Debout');
        $user->setEmail('francois@oclock.io');
        $user->setPhone('12345678');
        $user->setPassword('$2y$13$KC2blsGHwyGZKOu0t4TZIOzyve3aow9vU9fzPuIyshe/SmVou0yMG');
        $user->setRoles(['ROLE_PRODUCER']);

        // donner a doctrine
        $manager->persist($user);
        $manager->flush();
        $user = $manager->getRepository(User::class)->findBy(array(), array('id' => 'desc'), 1, 0)[0];
        //   dd($user)    ;     
        // ! FIXTURE STORE 10
        $store = new Store();
        $store->setSiret("0000");
        $store->setName("Earl du creux de pommier");
        $store->setStreet("grande rue");
        $store->setNumber("");
        $store->setZip("21440");
        $store->setCity("LAMARGELLE");
        $store->setPhone("0102030405");
        $store->setSchedules("Ouvert de 9h à 12h et de 13h à 18h");
        $store->setWebsite("https://www.facebook.com/earlducreuxdepommier/");
        $store->setDescription("Vente de produits de la ferme d'excellente qualité");
        $store->setUser($user);

        $manager->persist($store);
        // dd($user); 
        // dd($store);


        // ! FIXTURE ORDER 10
        // Instanciation d'une commande vide

        $order = new Order();
        $order->setOrderPrice(30);
        $order->setQuantity(3);
        $order->setUser($user);
        $order->setStore($store);

        $manager->persist($order);

        // ! FIXTURE CATEGORY 10

        $category = new Category();
        $category->setName("Vin et boissons");
        $category->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta finibus euismod. ");
        $category->setPicture('450, 300, true');

        // Prépare la sauvegarde
        $manager->persist($category);

        // ! FIXTURE PRODUCT 10
        $product = new Product();

        // Définition des paramètres des fixtures
        $product->setName("Jus de carotte (75 cl)");
        $product->setDescription("Produit d'excellente qualité mis sous vide pour une meilleure conservation");
        $product->setPrice(3.64);
        $product->setVatRate("5,5%");
        $product->setUnitOfMeasurement("Litre");
        $product->setPricePerUnit(4.85);
        $product->setStock(50);
        $product->setPicture("https://cdn.pixabay.com/photo/2017/08/08/08/58/carrot-2610757_1280.jpg");
        $product->setHeartLike(0);
        $product->setStore($store);
        $product->setCategory($category);

        $manager->persist($product);
        $manager->flush();
        //   dd($user);
        //   dd($store);
        //   dd($product);
        //   dd($order);           
        //   dd($category);
    }
}
