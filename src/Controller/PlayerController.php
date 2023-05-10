<?php

namespace App\Controller;


use App\Entity\Player;
use App\Form\PlayerType;
use App\Helper\FormErrorsToArray;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class PlayerController extends AbstractController
{


 /* public function index(): JsonResponse
    {
        return $this->json([
            'title' => 'Player',
            'path' => 'src/Controller/PlayerController.php',
        ]);
    } */



            private $entityManager;
            private $playerRepository;

           // private $validator;


      public function __construct(EntityManagerInterface $entityManager, PlayerRepository $playerRepository, ValidatorInterface $validator)
          {
                      $this->entityManager= $entityManager;
                      $this->playerRepository= $playerRepository;
                     // $this->validator= $validator;
          }




      #[Route('player', name:'player_index', methods:"GET")]
          public function index():Response{
          $player = $this->playerRepository->findALL();

             return $this->json($player, 200,[], ['groups'=>'player'] );

            }


    #[Route('player/create',name: 'player_create', methods:"POST")]

    public function create(Request $request, PlayerRepository $playerRepository): Response
    {

       $player = new Player();
       $form = $this->createForm(PlayerType::class, $player);


       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
           $playerRepository->save($player, true);
           return new JsonResponse(['message'=> 'Player create successfully'], Response::HTTP_CREATED);
       }

       return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)],Response::HTTP_BAD_REQUEST);


    }


       #[Route('player/delete/{id}', name:'player_delete', methods:"DELETE")]
       public function delete(Player $player):Response{
           $this->entityManager->remove($player);
           $this->entityManager->flush();

           return $this->json(null,204);
       }


       #[Route('player/update/{id}', name:'player_update', methods: "PUT")]
        public function update(Request $request, Player $player,PlayerRepository $playerRepository):Response{

          $form = $this->createForm(PlayerType::class, $player ,["method"=> "PUT"]);
          $form->handleRequest($request);
           if($form->isSubmitted() && $form->isValid()){
               $player = $form->getData();
               $playerRepository->save($player, true);
               return new JsonResponse(['message'=> 'Player update successfully'], Response::HTTP_CREATED);
           }

           return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)],Response::HTTP_BAD_REQUEST);

       }


       #[Route('player/show/{id}', name:'player_show',methods: "GET")]
        public function show(Player $player):Response{
                     return new Response(sprintf(
               'dni: %s name: %s last_name: %s team: %s salary: %d position: %s dorsal: %d email: %s phone: %s',
                   $player->getDni(),
                   $player->getName(),
                   $player->getLastName(),
                   $player->getTeam(),
                   $player->getSalary(),
                   $player->getPosition(),
                   $player->getDorsal(),
                   $player->getEmail(),
                   $player->getPhone()
            ));
       }


}
