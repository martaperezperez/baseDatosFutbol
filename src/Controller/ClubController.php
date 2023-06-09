<?php

namespace App\Controller;


use App\Entity\Club;
use App\Repository\ClubRepository;
use App\Entity\Coach;
use App\Entity\Player;
use App\Form\ClubType;
use App\Form\CoachType;
use App\Form\PlayerType;
use App\Helper\FormErrorsToArray;
use App\Repository\CoachRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

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

    private $playerRepository;

    private $mailer;


    public function __construct(EntityManagerInterface $entityManager, ClubRepository $clubRepository, PlayerRepository $playerRepository,  MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->clubRepository = $clubRepository;
        $this->playerRepository=$playerRepository;
        $this->mailer=$mailer;

    }
    #[Route('club', name: 'club_index', methods: "GET")]
    #[OA\Get(path: '/club', tags: ['Club'])]
    public function index():Response{
      $clubs = $this->clubRepository->findAll();
      $data = [];
      foreach ($clubs as $club){
          $id= $club->getId();
          $name = $club->getName();
          $budget = $club->getBudget();
          $email = $club->getEmail();
          $phone = $club->getPhone();

          $data[]= [
              'id'=>$id,
              'name'=>$name,
              'budget'=>$budget,
              'email'=>$email,
              'phone'=>$phone,
          ];
      }
      return $this->json(["Clubs"=>$data]);
    }



    #[Route('club/create','club_create',methods: "POST")]
    #[OA\Post(path: '/club/create', tags: ['Club'])]
    public function create(Request $request, ClubRepository $clubRepository): Response{

        $club = new Club();
        $form= $this->createForm(ClubType::class, $club);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $clubRepository->save($club, true);
        //    $email = (new Email())
        //        ->from('marta.perez@xilon.es')
        //        ->to($club->getEmail())
        //        ->subject('Dar de Alta Club')
        //        ->text('Has sido dado de alta como un Club ');
        //    $this->mailer->send($email);
            return new JsonResponse(['message'=>'Club create successfully'], Response::HTTP_CREATED);
        }

        return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)], Response::HTTP_BAD_REQUEST);

    }


    #[Route('club/delete/{id}', name:'club_delete', methods:"DELETE")]
    #[OA\Delete(path: '/club/delete/{id}', tags: ['Club'])]
    public function delete(Club $club):Response{
        $this->entityManager->remove($club);
        $this->entityManager->flush();
      //  $email = (new Email())
      //      ->from('marta.perez@xilon.es')
      //      ->to($club->getEmail())
      //      ->subject('Dar de Baja Club')
      //      ->text('Has sido dado de baja como Club ');
      //  $this->mailer->send($email);
        return new JsonResponse(['message' => 'Club successfully removed'], Response::HTTP_CREATED);

       // return $this->json(null, 204);
    }


    #[Route('club/update/{id}', name:'club_update', methods:"PUT")]
    #[OA\Put(path: '/club/update/{id}', tags: ['Club'])]
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
    #[OA\Get(path: '/club/show/{id}', tags: ['Club'])]
    public function show(Club $club):Response{
        return $this->json(sprintf(
            'name: %s budget: %d email: %s phone: %s',
            $club->getName(),
            $club->getBudget(),
            $club->getEmail(),
            $club->getPhone()
        ));
    }


    #[Route('club/{id}/create_player/', name: 'club_create_player', methods:"POST")]
    #[OA\Post(path: '/club/{id}/create_player/', tags: ['Club Player'])]
    public function cratePlayer(Request $request, Club $club ,PlayerRepository $playerRepository): Response{

        $player = new Player();
        $player->setClub($club);
        $form = $this->createForm(PlayerType::class, $player, ["method"=> "POST"]);
        $form->handleRequest($request);
        try {
             if($form->isSubmitted() && $form->isValid()){
                 $playerRepository->save($player, true);
                 $email = (new Email())
                     ->from('marta.perez@xilon.es')
                     ->to($player->getEmail())
                     ->subject('Dar de Alta Player en un club')
                     ->text('Has sido dado de alta como  Player');
                 $this->mailer->send($email);
                 return new JsonResponse(['message'=>'Player in Club Create successfully'], Response::HTTP_CREATED);
             }
              return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)],Response::HTTP_BAD_REQUEST);
        }catch(\Exception $e){
            return new JsonResponse('Error '.$e->getMessage());
        }
        //return  $this->redirectToRoute('club_show',['clubId'=> $club->getId()]);

    }



    #[Route('club/{id}/create_coach', name: 'club_create_coach', methods: "POST")]
    #[OA\Post(path: '/club/{id}/create_coach', tags: ['Club Coach'])]
    public function createCoach(Request $request, Club $club, CoachRepository $coachRepository):Response
    {
        $coach = new Coach();
        $coach->setClub($club);
        $form = $this->createForm(CoachType::class, $coach, ["method" => "POST"]);
        $form->handleRequest($request);

        try {
            (new \App\Validator\CoachSalaryValidator)->validateCoachSalary($coach);

            if ($form->isSubmitted() && $form->isValid()) {


                $coachRepository->save($coach, true);
                $email = (new Email())
                    ->from('marta.perez@xilon.es')
                    ->to($coach->getEmail())
                    ->subject('Dar de Alta Coach en un Club')
                    ->text('Has sido dado de alta como Coach en un Club ');
                $this->mailer->send($email);

                return new JsonResponse(['message' => 'Coach i Club Create successfully'], Response::HTTP_CREATED);

            }

            return new JsonResponse(['errors' => FormErrorsToArray::staticParseErrorsToArray($form)], Response::HTTP_BAD_REQUEST);


        } catch (\Exception $e) {
            return new JsonResponse('Error ' . $e->getMessage());


        }
    }

    #[Route('club/{id}/delete_player/{player_id}', name: 'club_delete_player', methods: "DELETE")]
    #[ParamConverter("player", options:[ 'mapping' =>["player_id"=> "id"], 'exclude'=>["id"]])]
    #[ParamConverter("club", options: ['mapping'=>["id"=>"id"], 'exclude'=>["player_id"]])]
    #[OA\Delete(path: '/club/{id}/delete_player/{player_id}', tags: ['Club Player'])]
    public function deletePlayer(Club $club, Player $player): Response{


        $this->entityManager->remove($player);
        $this->entityManager->flush();
        $email = (new Email())
            ->from('marta.perez@xilon.es')
            ->to($player->getEmail())
            ->subject('Dar de Baja Player en un Club')
            ->text('Has sido dado de baja como Player en un Club');
        $this->mailer->send($email);

        return $this->json(null, 204);
    }



    #[Route('club/{id}/delete_coach/{coach_id}', name: 'club_delete_coach', methods: "DELETE")]
    #[ParamConverter("coach", options:[ 'mapping'=>["coach_id"=>"id"], 'exclude'=>["id"]])]
    #[ParamConverter("club",options: ['mapping'=>["id"=>"id"], 'exclude'=>["coach_id"]])]
    #[OA\Delete(path: '/club/{id}/delete_coach/{coach_id}', tags: ['Club Coach'])]
    public function deleteCoach(Club $club, Coach $coach):Response{
        $this->entityManager->remove($coach);
        $this->entityManager->flush();
        $email = (new Email())
            ->from('marta.perez@xilon.es')
            ->to($coach->getEmail())
            ->subject('Dar de Baja Coach en un Club')
            ->text('Has sido dado de baja como Coach en un Club');
        $this->mailer->send($email);

        return $this->json(null, 204);
    }





}
