<?php

namespace App\Controller;

use DateTime;
use App\Entity\Todo;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class ApiListController extends AbstractController
{
    /**
     * @Route("/list", methods={"GET"})
     */
    public function listing()
    {
        $repository = $this->getDoctrine()->getRepository(Todo::class);
        $entities = $repository->findBy(['deleted' => false]);
        return $this->json($entities);
        
    }
      /**
     * @Route("/deleted", methods={"GET"})
     */
    public function listingDeleted()
    {
        $repository = $this->getDoctrine()->getRepository(Todo::class);


        $entities = $repository->findBy(['deleted' => true]);
        return $this->json($entities);
        
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request, EntityManagerInterface $repository, SerializerInterface $serializer)
    {
        // On recupère depuis la requête les data en JSON
        $data= $request->getContent();
// On deserialise les data pour hydrater un Objet de type Todo
        $dataAsObject = $serializer->deserialize($data, Todo::class, 'json');
// On envoie dans la BDD
        $repository->persist($dataAsObject);
        $repository->flush();
// La vie est belle, on fait savoir que ça s'est bien passé
        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );
    }
        /**
         * @Route("/delete", methods={"DELETE"})
         */
        public function delete(){
            return new JsonResponse(
            [
        'status' => 'ok',
    ],
    JsonResponse::HTTP_CREATED
);
        }
    
    }


    // public function form(Instruction $instruction = null,Request $request, EntityManagerInterface $manager)
    // {
    //     if(!$instruction){
    //         $instruction = new Instruction();
    //     }
        
    //     $form=$this->createForm(AjoutInstructionType::class, $instruction);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $manager->persist($instruction);
    //         $manager->flush();
    // if($instruction->getType()==0){
    //     return $this->redirectToRoute('autorise');
    // }else{
    //     return $this->redirectToRoute('non-autorise');
    // }
            
    //     }
    //     return $this->render('instructions/index.html.twig', [
    //         'formAjoutInstruction' => $form->createView(),
    //         'editMode' => $instruction->getId() !== null
    //     ]);
    //     }

