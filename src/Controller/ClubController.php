<?php

namespace App\Controller;


use App\Entity\Club;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function create(Request $request): Response{
        $data = json_decode($request->getContent(), true);


        $club= new Club();
        $club->setName($data['name'] ?? 'Default name');
        $club->setBudget(rand(1000,2000));
        $club ->setEmail($data['email']??'Default email');
        $club->setPhone($data['telefono']??'Default telefono');


        $this->entityManager->persist($club);
        $this->entityManager->flush();

        return new Response(sprintf(
            'name: %s presupuesto: %d email: %s telefono: %s',
            $club->getName(),
            $club->getBudget(),
            $club->getEmail(),
            $club->getPhone()
        ));



    }


    #[Route('club/eliminar/{id}', name:'club_eliminado', methods:"DELETE")]
    public function delete(Club $club):Response{
        $this->entityManager->remove($club);
        $this->entityManager->flush();

        return $this->json(null, 204);
    }


    #[Route('club/update/{id}', name:'club_update', methods:"PUT")]
    public function update(Request $request, Club $club): Response{


        $data = json_decode($request->getContent(), true);


        $club->setName('Marta');
        $club->setBudget(rand(1000,2000));
        $club->setEmail('jahsfir@gmail.com');
        $club->setPhone('66279502');

        $this->entityManager->flush();

        return new Response(sprintf(
            'nombre: %s presupuesto: %d email: %s telefono: %s',
            $club->getName(),
            $club->getBudget(),
            $club->getEmail(),
            $club->getPhone()
        ));

    }

    #[Route('club/show/{id}', name: 'club_show', methods: "GET")]
    public function show(Club $club):Response{
        return new Response(sprintf(
            'nombre: %s presupuesto. %d email: %s telefono: %s',
            $club->getName(),
            $club->getBudget(),
            $club->getEmail(),
            $club->getPhone()
        ));
    }

}
