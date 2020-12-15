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
        $password = $data['password'];


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
        if(
        $user = $this->userRepository->findOneBy(['id' => $id]))
        {

        $data[] = [
            'id' => $user->getId(),
            'firstName' => $user->getFirstame(),
            'lastName' => $user->getName(),
            'email' => $user->getEmail(),
            'phoneNumber' => $user->getPhoneNumber(),
            'username' => $user->getUsername(),
            'city' => $user->getCity(),
        ];
        if (empty($data))
          return new JsonResponse(['Error' => 'this user doesnt exist!'], Response::HTTP_OK);

     return new JsonResponse($data, Response::HTTP_OK);}
          else return new JsonResponse(['status' => 'merde'], Response::HTTP_OK);
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
                'firstName' => $users->getFirstame(),
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
        empty($data['name']) ? true : $user->setPassword($data['password']);
        empty($data['firstname']) ? true : $user->setPassword($data['streetname']);
        empty($data['email']) ? true : $user->setPassword($data['email']);
        empty($data['streetname']) ? true : $user->setPassword($data['streetname']);
        empty($data['street_number']) ? true : $user->setPassword($data['street_number']);
        empty($data['postal_code']) ? true : $user->setPassword($data['postal_code']);
        empty($data['city']) ? true : $user->setPassword($data['bio']);
        empty($data['phone_number']) ? true : $user->setPassword($data['phone_number']);

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
