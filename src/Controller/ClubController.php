<?php

namespace App\Controller;


use App\Entity\Club;
use App\Entity\Player;
use App\Form\ClubType;
use App\Form\PlayerType;
use App\Helper\FormErrorsToArray;
use App\Repository\ClubRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClubController extends AbstractController
{
//    #[Route('/club', name: 'app_club')]
    //   public function index(): JsonResponse
    //   {
//
//
    //       return $this->json([
    //           'message' => 'Club',
    //           'path' => 'src/Controller/ClubController.php',
    //       ]);
    //   }


    private $entityManager;
    private  $clubRepository;




    public function __construct(EntityManagerInterface $entityManager, ClubRepository $clubRepository)
    {
        $this->entityManager = $entityManager;
        $this->clubRepository = $clubRepository;

    }
    #[Route('club', name: 'club_index', methods: "GET")]
    public function index():Response{
        $club = $this->clubRepository->findAll();

        return $this->json($club, 200, [], ['groups'=>'clubs']);
    }



    #[Route('club/create','club_create',methods: "POST")]
    public function create(Request $request, ClubRepository $clubRepository): Response{

        $club = new Club();
        $form= $this->createForm(ClubType::class, $club);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $clubRepository->save($club, true);

            return new JsonResponse(['message'=>'Club reate successfully'], Response::HTTP_CREATED);
        }

        return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)], Response::HTTP_BAD_REQUEST);

    }


    #[Route('club/delete/{id}', name:'club_delete', methods:"DELETE")]
    public function delete(Club $club):Response{
        $this->entityManager->remove($club);
        $this->entityManager->flush();

        return $this->json(null, 204);
    }


    #[Route('club/update/{id}', name:'club_update', methods:"PUT")]
    public function update(Request $request, Club $club,ClubRepository $clubRepository): Response{

        $form = $this->createForm(ClubType::class, $club, ["method"=>"PUT"]);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $club= $form->getData();
            $clubRepository->save($club, true);
            return new JsonResponse(['message'=>'Club update successfully'], Response::HTTP_CREATED);
        }

        return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form), Response::HTTP_BAD_REQUEST]);

    }

    #[Route('club/show/{id}', name: 'club_show', methods: "GET")]
    public function show(Club $club):Response{
        return new Response(sprintf(
            'name: %s budget: %d email: %s phone: %s',
            $club->getName(),
            $club->getBudget(),
            $club->getEmail(),
            $club->getPhone()
        ));
    }

    #[Route('club/{id}/create_player/', name: 'club_create_player', methods:"POST")]
    public function cratePlayer(Request $request, Club $club ,PlayerRepository $playerRepository): Response{

        $player = new Player();
        $player->setClub($club);
        $form = $this->createForm(PlayerType::class, $player, ["method"=> "POST"]);

        $form->handleRequest($request);

        $playerRepository->save($player,true);

        if($form->isSubmitted() && $form->isValid()){
            $playerRepository->save($player, true);
            return new JsonResponse(['message'=>'PlayerCreate successfully'], Response::HTTP_CREATED);
        }


        //return  $this->redirectToRoute('club_show',['clubId'=> $club->getId()]);

        return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)],Response::HTTP_BAD_REQUEST);

    }





}
