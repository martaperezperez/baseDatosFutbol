<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Form\CoachType;
use App\Helper\FormErrorsToArray;
use App\Repository\CoachRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class coachController extends AbstractController
{


    private $entityManager;

    private $coachRepository;

    public function __construct(EntityManagerInterface $entityManager, CoachRepository $coachRepository){

        $this->entityManager=$entityManager;
        $this->coachRepository=$coachRepository;

    }

    #[Route('coach', name:'coach_index', methods:"GET")]
    public function index():Response{

        $coach = $this->coachRepository->findAll();

        return $this->json($coach, 200, [], ['groups'=>'coach'] );

    }

    #[Route('coach/create', name: 'coach_create', methods:"POST")]
    public function create(Request $request, CoachRepository $coachRepository): Response{

        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $coachRepository->save($coach, true);

            return new JsonResponse(['message' => 'Coach create successfully'], Response::HTTP_CREATED);

        }

        return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)], Response::HTTP_BAD_REQUEST);

    }

    #[Route('coach/delete/{id}', name: 'coach_delete', methods:"DELETE")]
    public function delete(Coach $coach):Response{
        $this->entityManager->remove($coach);
        $this->entityManager->flush();

        return $this->json(null, 204);


    }


    #[Route('coach/update/{id}', name: 'coach_update', methods: "PUT")]
    public function update(Request $request, Coach $coach): Response{


        $data = json_decode ($request->getContent(), true);


        $coach->setDni('193275Y');
        $coach->setName('Marta');
        $coach->setLastname('Perez');
        $coach->setTeam('Mongolos');
        $coach->setSalary(rand(1000,2000));
        $coach->setEmail('kjifdouor@gmail.com');
        $coach->setPhone('68352450');

        $this->entityManager->flush();

        return new Response(sprintf(
            'dni: %s name: %s last_name: %s team: %s salary: %d email: %s phone: %d',
            $coach->getDni(),
            $coach->getName(),
            $coach->getLastname(),
            $coach->getTeam(),
            $coach->getSalary(),
            $coach->getEmail(),
            $coach->getPhone()
        ));

    }

    #[Route('coach/show/{id}', name: 'coach_show', methods: "GET")]
    public function show(Coach $coach):Response{
        return new Response(sprintf(
            'dni. %s name: %s last_name: %s team: %s salary: %d email: %s phone: %d',
            $coach->getDni(),
            $coach->getName(),
            $coach->getLastname(),
            $coach->getTeam(),
            $coach->getSalary(),
            $coach->getEmail(),
            $coach->getPhone()
        ));

    }
}
