<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class UserController extends AbstractController
{

    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    /**
     * @Route("/test", name="test", methods={"get"})
     */
    public function test(): JsonResponse
    {

        $data=[
            'message' =>'bienvenue dans l\'api sapozone'
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/users/", name="add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $username = $data['username'];
        $password =password_hash($data['password'],PASSWORD_BCRYPT);


        if (empty($username) || empty($password)|| empty($email)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->userRepository->saveUser($username,$email, $password);

        return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }


    /**
     * @Route("/users/{id}", name="getOneUser", methods={"GET"})
     */
    public function getOneUser($id):JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (empty($user))
            return new JsonResponse(['Error' => 'this user doesnt exist!'], Response::HTTP_OK);
        $data[] = $user->toArray();
        if (empty($data))
          return new JsonResponse(['Error' => 'this user doesnt exist!'], Response::HTTP_OK);

     return new JsonResponse($data, Response::HTTP_OK);}

    /**
     * @Route("/sign_in/", name="signin", methods={"POST"})
     */
    public function signin(Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $username = $data['username'];
        $password = $data['password'];


        if ((empty($username) && empty($email)) || empty($password)) {
            return new JsonResponse(['Error' => 'expecting mandatory parameters'], Response::HTTP_CREATED);
        }

        $user=$this->userRepository->findOneBy(['username' => $username]);
        $data=$user->toArray();

        if(password_hash($password,PASSWORD_BCRYPT)==$user->getPassword())
        return new JsonResponse($data, Response::HTTP_CREATED);
        else return new JsonResponse(['Error' => 'wrong password'], Response::HTTP_CREATED);
    }



    /**
     * @Route("/users", name="getall", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $data = [];

        foreach ($users as $users) {
            $data[] = [
                'id' => $users->getId(),
                'firstName' => $users->getFirstname(),
                'lastName' => $users->getName(),
                'email' => $users->getEmail(),
                'phoneNumber' => $users->getPhoneNumber(),
                'username' => $users->getUsername(),
                'city' => $users->getCity(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);

    }
    /**
     * @Route("/users/{id}", name="update_customer", methods={"PUT"})
     */
    public function updateUser($id, Request $request): JsonResponse
    {
        if(
        $user = $this->userRepository->findOneBy(['id' => $id]))
        {

        $data = json_decode($request->getContent(), true);

        empty($data['username']) ? true : $user->setUsername($data['username']);
        empty($data['password']) ? true : $user->setPassword($data['password']);
        empty($data['lastname']) ? true : $user->setName($data['name']);
        empty($data['firstname']) ? true : $user->setFirstname($data['firstname']);
        empty($data['email']) ? true : $user->setEmail($data['email']);
        empty($data['streetname']) ? true : $user->setStreetname($data['streetname']);
        empty($data['street_number']) ? true : $user->setStreetNumber($data['street_number']);
        empty($data['postal_code']) ? true : $user->setPostalCode($data['postal_code']);
        empty($data['city']) ? true : $user->setCity($data['city']);
        empty($data['phone_number']) ? true : $user->setPhoneNumber($data['phone_number']);
        empty($data['bio']) ? true : $user->setBio($data['bio']);

        $updatedUser = $this->userRepository->updateUser($user);

        return new JsonResponse($updatedUser->toArray(), Response::HTTP_OK);}
        else return new JsonResponse(['status' => 'merde'], Response::HTTP_OK);
    }
    /**
     * @Route("/users/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        $this->userRepository->removeUser($user);

        return new JsonResponse(['status' => 'user deleted'], Response::HTTP_NO_CONTENT);
    }


    /**
     * @Route("/", name="")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }
}
