<?php


namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;




class StoreController extends AbstractController
{

    private $storeRepository;
    private $userRepository;
    public function __construct(StoreRepository $storeRepository,UserRepository $userRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->userRepository = $userRepository;
    }




    /**
     * @Route("/stores/", name="add_store", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add_store(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $ownerid = $data['owner'];
        $name = $data['name'];



        $owner= $this->userRepository->find($ownerid);

        if (empty($name) || empty($owner)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        $this->storeRepository->saveStore($owner,$name);
        return new JsonResponse(['status' => 'Store created!'], Response::HTTP_CREATED);
    }


    /**
     * @Route("/stores/{id}", name="get_one_store", methods={"GET"})
     */
    public function getOnestore($id):JsonResponse
    {
        $store = $this->storeRepository->findOneBy(['id' => $id]);

        $data = $store->toArray();

        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("/stores/{city}", name="getstore_city", methods={"GET"})
     */
    public function getStore_city($city):JsonResponse
    {
        $stores = $this->storeRepository->findBy(['city' => $city]);

        foreach ($stores as $store) {
            $data[] = [
                $store->toArray()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("/stores/", name="getAll", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $stores = $this->storeRepository->findAll();



        foreach ($stores as $store) {
            $data[] = [
                "name" => $store->getName()
            ];
        }


        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("/stores/{id}", name="update_store", methods={"PUT"})
     */
    public function updateStore($id, Request $request): JsonResponse
    {
        $store = $this->storeRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $store->setName($data['name']);
        empty($data['streetname']) ? true : $store->setStreetName($data['streetname']);
        empty($data['street_number']) ? true : $store->setStreetNUMBER($data['street_number']);
        empty($data['city']) ? true : $store->setCity($data['city']);
        empty($data['bio']) ? true : $store->setBio($data['bio']);
        empty($data['phone_number']) ? true : $store->setPhoneNumber($data['phone_number']);
        empty($data['postal_code']) ? true : $store->setPostalCode($data['postal_code']);

        $updatedstore = $this->storeRepository->updatestore($store);

        return new JsonResponse($updatedstore->toArray(), Response::HTTP_OK);
    }
    /**
     * @Route("/stores/{id}", name="delete_customer", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $store = $this->storeRepository->findOneBy(['id' => $id]);

        $this->storeRepository->removeStore($store);

        return new JsonResponse(['status' => 'user deleted'], Response::HTTP_NO_CONTENT);
    }


}