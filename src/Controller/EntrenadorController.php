<?php

namespace App\Controller;

use App\Entity\Entrenador;
use App\Repository\EntrenadorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EntrenadorController extends AbstractController
{


    private $entityManager;

    private $entrenadorRepository;

    public function __construct(EntityManagerInterface $entityManager, EntrenadorRepository $entrenadorRepository){

        $this->entityManager=$entityManager;
        $this->entrenadorRepository=$entrenadorRepository;

    }

    #[Route('entrenador', name:'entrenador_index', methods:"GET")]
    public function index():Response{

        $entrenador = $this->entrenadorRepository->findAll();

        return $this->json($entrenador, 200, [], ['groups'=>'entrenador'] );

    }

    #[Route('entrenador/create', name: 'entrenador_create', methods:"POST")]
    public function create(Request $request): Response{
        $data = json_decode($request->getContent(), true);

        $entrenador = new Entrenador();
        $entrenador->setDni($data['dni']?? 'Default dni')
            ->setName($data['name'] ?? 'Default name')
            ->setLastname($data['apellidos']?? 'Default apellidos')
            ->setTeam($data['apellidos']?? 'Default equipo')
            ->setSalary(rand(1000,2000))
            ->setEmail($data['email']?? 'Defaut email')
            ->setPhone('66847023');

        $this->entityManager->persist($entrenador);
        $this->entityManager->flush();

        return new Response(sprintf(
            'dni: %s nombre: %s apellidos: %s equipo: %s salario: %d email: %s telefono: %d',
            $entrenador->getDni(),
            $entrenador->getName(),
            $entrenador->getLastname(),
            $entrenador->getTeam(),
            $entrenador->getSalary(),
            $entrenador->getEmail(),
            $entrenador->getPhone()
        ));

    }

    #[Route('entrenador/delete/{id}', name: 'entrenador_delete', methods:"DELETE")]
    public function delete(Entrenador $entrenador):Response{
        $this->entityManager->remove($entrenador);
        $this->entityManager->flush();

        return $this->json(null, 204);


    }


    #[Route('entrenador/update/{id}', name: 'entrenador_update', methods: "PUT")]
    public function update(Request $request, Entrenador $entrenador): Response{


        $data = json_decode ($request->getContent(), true);


        $entrenador->setDni('193275Y');
        $entrenador->setName('Marta');
        $entrenador->setLastname('Perez');
        $entrenador->setTeam('Mongolos');
        $entrenador->setSalary(rand(1000,2000));
        $entrenador->setEmail('kjifdouor@gmail.com');
        $entrenador->setPhone('68352450');

        $this->entityManager->flush();

        return new Response(sprintf(
            'dni: %s nombre: %s apellidos: %s equipo: %s salario: %d email: %s telefono: %d',
            $entrenador->getDni(),
            $entrenador->getName(),
            $entrenador->getLastname(),
            $entrenador->getTeam(),
            $entrenador->getSalary(),
            $entrenador->getEmail(),
            $entrenador->getPhone()
        ));

    }

    #[Route('entrenador/show/{id}', name: 'entrenador_show', methods: "GET")]
    public function show(Entrenador $entrenador):Response{
        return new Response(sprintf(
            'dni. %s nombre: %s apellidos: %s equipo: %s salario: %d email: %s telefono: %d',
            $entrenador->getDni(),
            $entrenador->getName(),
            $entrenador->getLastname(),
            $entrenador->getTeam(),
            $entrenador->getSalary(),
            $entrenador->getEmail(),
            $entrenador->getPhone()
        ));

    }
}
