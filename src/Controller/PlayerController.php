<?php

namespace App\Controller;


use App\Entity\Player;
use App\Form\PlayerType;
use App\Helper\FormErrorsToArray;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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

            private $mailer;

           // private $validator;


      public function __construct(EntityManagerInterface $entityManager, PlayerRepository $playerRepository, ValidatorInterface $validator, MailerInterface $mailer)
          {
                      $this->entityManager= $entityManager;
                      $this->playerRepository= $playerRepository;
                      $this->mailer=$mailer;
                     // $this->validator= $validator;
          }




      #[Route('player', name:'player_index', methods:"GET")]
          public function index():Response{

          $players = $this-> playerRepository->findAll();
          $data = [];
          foreach ($players as $player){
              $id= $player->getId();
              $dni = $player->getDni();
              $name = $player->getName();
              $lastname = $player->getLastName();
              $team = $player->getTeam();
              $salary = $player->getSalary();
              $position = $player->getPosition();
              $dorsal = $player->getDorsal();
              $email = $player->getEmail();
              $phone = $player->getPhone();


              $data[]= [
                  'id' => $id,
                  'dni'=> $dni,
                  'name'=> $name,
                  'last_name'=> $lastname,
                  'team'=> $team,
                  'salary'=>$salary,
                  'position'=>$position,
                  'dorsal'=>$dorsal,
                  'email'=> $email,
                  'phone'=> $phone,
              ];

          }

          return $this ->json(["players" => $data]);
          //$player = $this->playerRepository->findALL();

          //   return $this->json($player, 200,[], ['groups'=>'player'] );

            }


    #[Route('player/create',name: 'player_create', methods:"POST")]

    public function create(Request $request, PlayerRepository $playerRepository): Response
    {

       $player = new Player();
       $form = $this->createForm(PlayerType::class, $player);

       $form->handleRequest($request);



       if($form->isSubmitted() && $form->isValid()){

           $playerRepository->save($player, true);

           $email = (new Email())
               ->from('marta.perez@xilon.es')
               ->to($player->getEmail())
               ->subject('Dar de Alta Player')
               ->text('Has sido dado de alta como  Player');
           $this->mailer->send($email);




           return new JsonResponse(['message'=> 'Player create successfully',['id:'=>$player->getId()]], Response::HTTP_CREATED);

       }


       
       return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)],Response::HTTP_BAD_REQUEST);

    }


       #[Route('player/delete/{id}', name:'player_delete', methods:"DELETE")]
       public function delete(Player $player):Response{
           $this->entityManager->remove($player);
           $this->entityManager->flush();

           $email = (new Email())
               ->from('marta.perez@xilon.es')
               ->to($player->getEmail())
               ->subject('Dar de Baja Player')
               ->text('Has sido dado de baja como Player ');
           $this->mailer->send($email);

           return new JsonResponse(['message' => 'Player successfully removed'], Response::HTTP_CREATED);
          // return $this->json(null,204);
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

    #[Route('club/{id}/index_player', name: 'club_index_player', methods: "GET")]
    public function list(Request $request, $id): Response
    {
        $property = $request->query->get('property'); // Obtener el valor del parámetro "property"
        $page = $request->query->getInt('page', 1); // Obtener el número de página actual

        $playerPerPage = 10; // Cantidad de jugadores por página

        $player = $this->playerRepository->findByClubAndProperty($id, $property);

        $totalplayer = count($player);
        $totalPages = ceil($totalplayer / $playerPerPage);

        $player = array_slice($player, ($page - 1) * $playerPerPage, $playerPerPage);

        $response = [
            'player' => $player,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];

        return new JsonResponse($response);
    }





}
