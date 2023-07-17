<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Security\Security;
use App\Security\ProfileSecurity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    private $jwtManager;
    private $tokenStorageInterface;
    private Security $security;
    private ProfileSecurity $profileSecurity;

    public function __construct(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager, Security $security, ProfileSecurity $profileSecurity)
    {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
        $this->security = $security;
        $this->profileSecurity = $profileSecurity;
    }


    #[Route('/hr/profile/view', name: 'app_profile_view', methods: ['GET'])]
    public function profileView(EntityManagerInterface $entityManager): jsonResponse
    {
        $return = [];
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        $email = $decodedJwtToken['username'];
        $user = $entityManager->getRepository(User::class)->findoneby(['email' => $email]);
        if ($user) {
            $return['pseudo'] = $user->getPseudo();
            $return['avatar'] = $user->getAvatar();

            if (count($user->getCar()) > 0) {
                foreach ($user->getCar() as $car) {
                    $c['carPicture'] = $car->getCarPicture();
                    $c['brand'] = $car->getModel()->getBrand()->getName();
                    $c['model'] = $car->getModel()->getName();
                    $c['color'] = $car->getColor();
                    $c['places'] = $car->getPlaces();
                    $c['smallBagage'] = $car->getSmallBaggage();
                    $c['largeBagage'] = $car->getLargeBaggage();
                    $return['car'][] = $c;
                }
            }

            if (count($user->getOptions()) > 0) {
                $return['options']['silence'] = $user->getOptions()[0]->isSilence();
                $return['options']['smoke'] = $user->getOptions()[0]->isSmoke();
                $return['options']['animals'] = $user->getOptions()[0]->isAnimals();
                if ($user->getOptions()[0]->isMusic()) {
                    $return['options']['music'] = true;
                    if (count($user->getOptions()[0]->getMusicOption()) > 0) {
                        foreach ($user->getOptions()[0]->getMusicOption() as $music) {
                            $return['options']['musicOption'][] = $music->getGenre();
                        }
                    }
                }
                else {
                    $return['options']['music'] = false;
                }
            }

            if (count($user->getComment()) > 0) {
                $return['comments']['total'] = count($user->getComment());
                $return['comments']['page'] = 1;
                $return['comments']['last'] = ceil(count($user->getComment()) / 5);
                $comment = $entityManager->getRepository(Comment::class)->findAverageByUser($user->getId());
                $return['comments']['averageScore'] = round($comment, 2);
                $comments = $entityManager->getRepository(Comment::class)->findBy(['owner' => $user->getId()], ['createdAt' => 'DESC'], 5);
                foreach ($comments as $comment) {
                    $com['createdAt'] = $comment->getCreatedAt();
                    $com['score'] = $comment->getScore();
                    $com['comments'] = $comment->getComment();
                    $return['comments']['comments'][] = $com;
                }
            }
            else {
                $return['comments']['total'] = 0;
            }

            return $this->json($return, 200);
        }
        else {
            $errors["userErr"] = "L'utilisateur n'existe pas !";
            return $this->json($errors, 400);
        }

    }


    #[Route('/hr/profile/view/{pseudo}', name: 'app_profile_view_user', methods: ['GET'])]
    public function profileViewUser($pseudo, EntityManagerInterface $entityManager): jsonResponse
    {
        $return = [];
        $user = $entityManager->getRepository(User::class)->findoneby(['pseudo' => $pseudo]);
        if ($user) {
            $return['pseudo'] = $user->getPseudo();
            $return['avatar'] = $user->getAvatar();

            if (count($user->getCar()) > 0) {
                foreach ($user->getCar() as $car) {
                    $c['carPicture'] = $car->getCarPicture();
                    $c['brand'] = $car->getModel()->getBrand()->getName();
                    $c['model'] = $car->getModel()->getName();
                    $c['color'] = $car->getColor();
                    $c['places'] = $car->getPlaces();
                    $c['smallBagage'] = $car->getSmallBaggage();
                    $c['largeBagage'] = $car->getLargeBaggage();
                    $return['car'][] = $c;
                }
            }

            if (count($user->getOptions()) > 0) {
                $return['options']['silence'] = $user->getOptions()[0]->isSilence();
                $return['options']['smoke'] = $user->getOptions()[0]->isSmoke();
                $return['options']['animals'] = $user->getOptions()[0]->isAnimals();
                if ($user->getOptions()[0]->isMusic()) {
                    $return['options']['music'] = true;
                    if (count($user->getOptions()[0]->getMusicOption()) > 0) {
                        foreach ($user->getOptions()[0]->getMusicOption() as $music) {
                            $return['options']['musicOption'][] = $music->getGenre();
                        }
                    }
                }
                else {
                    $return['options']['music'] = false;
                }
            }

            if (count($user->getComment()) > 0) {
                $return['comments']['total'] = count($user->getComment());
                $return['comments']['page'] = 1;
                $return['comments']['last'] = ceil(count($user->getComment()) / 5);
                $comment = $entityManager->getRepository(Comment::class)->findAverageByUser($user->getId());
                $return['comments']['averageScore'] = round($comment, 2);
                $comments = $entityManager->getRepository(Comment::class)->findBy(['owner' => $user->getId()], ['createdAt' => 'DESC'], 5);
                foreach ($comments as $comment) {
                    $com['createdAt'] = $comment->getCreatedAt()->format("Y-m-d h-m-s");
                    $com['score'] = $comment->getScore();
                    $com['comments'] = $comment->getComment();
                    $return['comments']['comments'][] = $com;
                }
            }
            else {
                $return['comments']['total'] = 0;
            }

            return $this->json($return, 200);
        }
        else {
            $errors["userErr"] = "L'utilisateur n'existe pas !";
            return $this->json($errors, 400);
        }

    }


    #[Route('/hr/profile/comments/{pseudo}', name: 'app_profile_comments', methods: ['GET'])]
    public function profileComments($pseudo, Request $request, EntityManagerInterface $entityManager): jsonResponse
    {
        $return = [];

        $page=(int)$request->query->get('page');
        if (isset($page)) {
            $page = $page > 0 ? $page : 1;
        }
        else {
            $page = 1;
        }

        $user = $entityManager->getRepository(User::class)->findoneby(['pseudo' => $pseudo]);
        if ($user) {
            if (count($user->getComment()) > 0) {
                $last = ceil(count($user->getComment()) / 5);
                $page = $page <= $last ? $page : $last;
                $offset = ($page - 1) * 5;

                $return['comments']['total'] = count($user->getComment());
                $return['comments']['page'] = $page;
                $return['comments']['last'] = $last;
                $comment = $entityManager->getRepository(Comment::class)->findAverageByUser($user->getId());
                $return['comments']['averageScore'] = round($comment, 2);
                $comments = $entityManager->getRepository(Comment::class)->findBy(['owner' => $user->getId()], ['createdAt' => 'DESC'], 5, $offset);
                foreach ($comments as $comment) {
                    $com['createdAt'] = $comment->getCreatedAt()->format("Y-m-d h-m-s");
                    $com['score'] = $comment->getScore();
                    $com['comments'] = $comment->getComment();
                    $return['comments']['comments'][] = $com;
                }
            }
            else {
                $return['comments']['total'] = 0;
            }

            return $this->json($return, 200);
        }
        else {
            $errors["userErr"] = "L'utilisateur n'existe pas !";
            return $this->json($errors, 400);
        }

    }


    #[Route('/hr/profile/update/read', name: 'app_profile_update_read', methods: ['GET'])]
    public function profileUpdateRead(EntityManagerInterface $entityManager): jsonResponse
    {
        $return = [];
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        $email = $decodedJwtToken['username'];
        $user = $entityManager->getRepository(User::class)->findoneby(['email' => $email]);
        if ($user) {
            $return['email'] = $user->getEmail();
            $return['pseudo'] = $user->getPseudo();
            $return['firstName'] = $user->getFirstName();
            $return['lastName'] = $user->getLastName();
            $return['avatar'] = $user->getAvatar();
            $return['birthDate'] = $user->getBirthDate()->format("Y-m-d");;
            $return['totalCredits'] = $user->getTotalCredits();

            if (count($user->getCar()) > 0) {
                foreach ($user->getCar() as $car) {
                    $c['carPicture'] = $car->getCarPicture();
                    $c['brand'] = $car->getModel()->getBrand()->getName();
                    $c['model'] = $car->getModel()->getName();
                    $c['color'] = $car->getColor();
                    $c['places'] = $car->getPlaces();
                    $c['smallBagage'] = $car->getSmallBaggage();
                    $c['largeBagage'] = $car->getLargeBaggage();
                    $return['car'][] = $c;
                }
            }

            if (count($user->getOptions()) > 0) {
                $return['options']['silence'] = $user->getOptions()[0]->isSilence();
                $return['options']['smoke'] = $user->getOptions()[0]->isSmoke();
                $return['options']['animals'] = $user->getOptions()[0]->isAnimals();
                if ($user->getOptions()[0]->isMusic()) {
                    $return['options']['music'] = true;
                    if (count($user->getOptions()[0]->getMusicOption()) > 0) {
                        foreach ($user->getOptions()[0]->getMusicOption() as $music) {
                            $return['options']['musicOption'][] = $music->getGenre();
                        }
                    }
                }
                else {
                    $return['options']['music'] = false;
                }
            }

            return $this->json($return, 200);
        }
        else {
            $errors["userErr"] = "L'utilisateur n'existe pas !";
            return $this->json($errors, 400);
        }

    }


    #[Route('/hr/profile/update/write', name: 'app_profil_update_write', methods: ['PATCH'])]
    public function profileUpdateWrite(Request $request, EntityManagerInterface $entityManager): jsonResponse
    {
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        $email = $decodedJwtToken['username'];

        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        if ($data && count($data) == 2) {
            $keys = array_keys($data);
            $keysAccept = ['email', 'pseudo', 'firstName'];


        }
        else {
            $errors["jsonErr"] = "Le format des données envoyées n'est pas correct !";
            return $this->json($errors, 400);
        }

    }


    #[Route('/hr/profile/update/password', name: 'app_profil_update_password', methods: ['PATCH'])]
    public function profileUpdatepassword(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordHasherInterface $userPasswordHasher): jsonResponse
    {
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        $email = $decodedJwtToken['username'];

        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        if ($data && count($data) == 2) {
            $keys = array_keys($data);
            if (array_diff($keys, ["old", "new"]) == []) {
                foreach ($keys as $key) {
                    $data[$key] = $this->security->secureData($data[$key]);
                }
                $contraints = $this->profileSecurity->emailContraints();
                $invalid = $validator->validate($data, $contraints);
                $violation = [];
                foreach ($invalid as $err) {
                    $violation[] = $err->getMessage();
                }
                if (count($violation) > 0) {
                    $errors["validErr"] = "Un ou plusieurs champs ne sont pas valides";
                    return $this->json($errors, 400);
                } 

                $user = $entityManager->getRepository(User::class)->findoneby(['email' => $email]);
                if ($user) {
                    if ($userPasswordHasher->isPasswordValid($user, $data['old'])) {
                        $user->setPassword($userPasswordHasher->hashPassword($user, $data['new']));
                        $entityManager->flush();
                        return $this->json(["passwordChange" => "Votre mot de passe est bien modifié !"], 200);
                    }
                    else {
                        $errors["oldErr"] = "Le mot de passe n'est pas vaide !";
                        return $this->json($errors, 400);
                    }
                }
                else {
                    $errors["userErr"] = "L'utilisateur n'existe pas !";
                    return $this->json($errors, 400);
                }
            } else {
                $errors["jsonErr"] = "Le format des données envoyées n'est pas correct !";
                return $this->json($errors, 400);
            }
        }
        else {
            $errors["jsonErr"] = "Le format des données envoyées n'est pas correct !";
            return $this->json($errors, 400);
        }

    }

}
