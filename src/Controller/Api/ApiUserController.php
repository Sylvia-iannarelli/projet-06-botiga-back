<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


class ApiUserController extends AbstractController
{

    /**
     * renvoie un user spécifique
     * @IsGranted("ROLE_USER")
     * @Route("/api/users/{id}", name="app_api_user_show", requirements={"id"="\d+"}, methods={"GET"})
     * @return JsonResponse
     */
    public function read($id, UserRepository $userRepository): JsonResponse
    {
        // le front nous retourne en GET/ user: https//api/user/id
        // En back nous retournons en JSON la liste de seul user en GET
        // TODO a faire definir ce que nous devons retouner par rapport aux Entity avec l'annotation @groups ({"user_show"})
        // Essai avec thunderClient : http://localhost:8000/api/users dans la class Entity : sur l'id  par exemple  @groups ({"user_show"})
        // Verification si le user existe ou pas avec un code 404  avec un message d'erreur
        // L'essai retourne bien une reponse JSON en code HTTP 200  avec un id du  user
        // test avec Thunder-Client pour les 2 situations
        // exemple : http://localhost:8000/api/users/12 => message d'erreur : le user n'existe pas
        // exemple : http://localhost:8000/api/users/2 => affiche un user


        // Récupération de l'ID d'un user
        $user = $userRepository->find($id);

        // On récupère l'user qui est connecté
        $userConnected = $this->getUser();

        // dd($userConnected);

        // $userConnected->getId();

        if ($id != $userConnected->getId()) {

            return $this->json(
                // 1. les données à renvoyer : la transformation en json est automatique
                "Vous ne pouvez pas accéder à cette page",
                // 2. code HTTP : 401
                Response::HTTP_UNAUTHORIZED,

            );

        }

        //dd($user) retourne bien un user avec toutes des proprietes;
        // TODO a faire verification gestion de la 404
        if ($user === null) {
            // ! on ne doit pas renvoyer du HTML
            // * le front s'attend à avoir du JSON
            // throw $this->createNotFoundException(); // renvoit du HTML
            return $this->json(
                // 1. les données à renvoyer : la transformation en json est automatique
                "Le user n'existe pas ",
                // 2. code HTTP : 404
                Response::HTTP_NOT_FOUND,
                // 3. pas d'entêtes particulière
                [],
                // 4. pas de contexte
                []
            );
        }

        return $this->json(
            // 1. les données à renvoyer : la transformation en json est automatique
            $user,
            // 2. code HTTP
            200,
            // 3. pas d'entêtes particulière
            [],
            // 4. le contexte
            // dans le contexte on précise le nom du/des groupes de serialisation
            [
                "groups" =>
                [
                    // je veux toutes les propriétés de ce groupe
                    "user_show"
                ]
            ]
        );
    }

    /**
     * @Route("/api/users/new", name="add", methods={"POST"})
     *
     *
     */
      // le front nous envoie POST user : https://api/users/create
      // En back nous retournons en JSON  un ajout d'un user
      // test avec thunderClient pour ajouter un user est toutes ses proprietes exemple : http://localhost:8000/api/users/create/12
      // Mise en place du serializer pour tester : il fonctionne
      // doc: https://symfony.com/doc/current/components/serializer.html


    public function add(
        UserRepository $userRepository,
        Request $request, 
        SerializerInterface $serializerInterface, 
        ValidatorInterface $validatorInterface,
        UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $jsonContent = $request->getContent();
        // on reçoit aucun JSON
        if ($jsonContent === "") {
            return $this->json("Le contenu de la requete est invalide", Response::HTTP_BAD_REQUEST);
        }

        $user = $serializerInterface->deserialize($jsonContent, User::class, 'json');

        $errors = $validatorInterface->validate($user);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // avant de sauvegarder l'utilisateur
        // on récupère le mot de passe en clair
        $plainTextPassword = $user->getPassword();
        // on hash son mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword);
        // et on lui redonne (on l'écrase)
        $user->setPassword($hashedPassword);

        $userRepository->add($user, true);

        return $this->json("ok", 200);
    }

        /**
     * @Route("/api/users/{id}", name="update", methods={"PUT", "PATCH"})
     *  @isGranted("ROLE_USER")
     */

      public function update($id,
          User $user= null,  
          UserRepository $userRepository,
          Request $request,
          SerializerInterface $serializerInterface,
          ValidatorInterface $validatorInterface,
          UserPasswordHasherInterface $userPasswordHasherInterface,
          EntityManagerInterface $entityManager
      ): JsonResponse {
          $jsonContent = $request->getContent();
          // on reçoit aucun JSON
          if ($jsonContent === "") {
              return $this->json("Le contenu de la requete est invalide", Response::HTTP_BAD_REQUEST);
          }

          $userData = $serializerInterface->deserialize($jsonContent, User::class, 'json');

          // $userConnected = $this->getUser();
          // dd($userConnected);
          // TODO Renforcement de la sécurité : bien vérifier que l'user qui est modifé soit l'user connecté

            // Récupération de l'ID d'un user
            $user = $userRepository->find($id);

            // On récupère l'user qui est connecté
            $userConnected = $this->getUser();
            // dd($id);

            if ($id != $userConnected->getId()) {

                return $this->json(
                    // 1. les données à renvoyer : la transformation en json est automatique
                    "Vous ne pouvez pas accéder à cette page",
                    // 2. code HTTP : 401
                    Response::HTTP_UNAUTHORIZED,

            );

        }

          // On désérialise le JSON vers l'entité user existante
          $user = $serializerInterface->deserialize($jsonContent, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

          // On valide l'entité
          $errors = $validatorInterface->validate($user);

          // ajoutez votre gestion des erreurs ici
          if (count($errors) > 0) {
              // ...
          }

        //   ! Ne pas réhasher le mot de passe
        //   ! Côté front, lors de la requête ils ne nous enverront pas de mot de passe
          // Enregistrement en BDD
          $entityManager->flush();


          return new JsonResponse(["message" => "utilisateur modifié"], Response::HTTP_OK);
      }
      

    /**
         * @Route("/api/users/delete/{id}", name="delete", requirements={"id"="\d+"}, methods={"DELETE"})
         * 
         *
         * @return JsonResponse
         */

         //Je peux par cette route faire un delete sur un users 
         //test avec thunderCliente : http://localhost:8000/api/users/delete/17
        public function delete(
            $id,
            UserRepository $userRepository
            ): JsonResponse
        {
            // 1. aller l'objet dans la BDD
            $user = $userRepository->find($id);
            // on a pas trouvé en BDD
            if ($user === null){
                return $this->json(
                    // 1. un message d'erreur
                    "Aucun USER avec cet ID : " . $id,
                    //2. code HTTP : 404 NOT_FOUND
                    Response::HTTP_NOT_FOUND,
                );
            }
            // 2. utiliser le repository pour faire un remove
            $userRepository->remove($user, true);
            // 3. on renvoit une réponse JSON
            return $this->json(
                // 1. aucune donnée à fournir, peut être un message
                null,
                //2. code HTTP : 204 NO_CONTENT
                Response::HTTP_NO_CONTENT,
            );
        }

}
