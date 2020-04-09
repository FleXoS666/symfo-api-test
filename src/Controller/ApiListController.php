<?php

namespace App\Controller;

use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiListController extends AbstractController
{
    /**
     * @Route("/list", name="api_list", methods={"GET"})
     */
    public function listing()
    {
        $repository = $this->getDoctrine()->getRepository(Todo::class);
        $entities = $repository->findBy(['deleted' => false]);
        return $this->json($entities);
        
    }
      /**
     * @Route("/deleted", name="api_deleted", methods={"GET"})
     */
    public function listingDeleted()
    {
        $repository = $this->getDoctrine()->getRepository(Todo::class);


        $entities = $repository->findBy(['deleted' => true]);
        return $this->json($entities);
        
    }

      /**
     * @Route("/add", name="api_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        // $data = json_decode($request->getContent(), true);

        // $item= new Todo();

        // // $repository = $this->getDoctrine()->getRepository($item);
        // $data = $request->getContent();
     
        
        $data = json_decode(
            $request->getContent(),
            true
        );
        $repository = $this->getDoctrine()->getRepository(Todo::class);
        $repository->persist($data);
        $repository->flush();
        dump($data);
        
        // return $this->json($entities);
        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );
    }
}
