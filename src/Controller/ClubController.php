<?php

namespace App\Controller;


use App\Entity\Club;
use App\Form\ClubType;
use App\Helper\FormErrorsToArray;
use App\Repository\ClubRepository;
use ContainerBtxjtRj\getDebug_ArgumentResolver_NotTaggedControllerService;
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

    private $validator;


    public function __construct(EntityManagerInterface $entityManager, ClubRepository $clubRepository, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->clubRepository = $clubRepository;
        $this->validator=$validator;
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

}
