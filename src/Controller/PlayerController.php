<?php

namespace App\Controller;


use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



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
            private $jugadorRepository;


      public function __construct(EntityManagerInterface $entityManager, PlayerRepository $jugadorRepository)
          {
                      $this->entityManager= $entityManager;
                      $this->jugadorRepository= $jugadorRepository;
          }




      #[Route('jugador', name:'jugador_indice', methods:"GET")]
          public function index():Response{
          $jugador = $this->jugadorRepository->findALL();

             return $this->json($jugador, 200,[], ['groups'=>'jugador'] );

            }


    #[Route('jugador/create',name: 'jugador_crear', methods:"POST")]

    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $jugador = new Player();
        $jugador->setDni($data['dni'] ?? 'Default dni')
            ->setName($data['name'] ?? 'Default name')
            ->setLast_name($data['last_name'] ?? 'Default last_name')
            ->setTeam($data['team'] ?? 'Default team')
            ->setSalary(rand(1000, 2000))
            ->setPosition($data['position'] ?? 'Default position')
            ->setDorsal(rand(0 , 20))
            ->setEmail($data['email'] ?? 'Default email')
            ->setPhone($data['phone'] ?? 'Default phone');

        $this->entityManager->persist($jugador);
        $this->entityManager->flush();
//      return $this->json($jugador, 201, [], ['groups' => 'club']);
        return new Response(sprintf(
            'dni: %s nombre:%s apellidos: %s equipo: %s salario: %d posicion: %s dorsal: %d email: %s telefono: %s',
            $jugador->getDni(),
                $jugador->getName(),
                $jugador->getLast_name(),
                $jugador->getTeam(),
                $jugador->getSalary(),
                $jugador->getPosition(),
                $jugador->getDorsal(),
                $jugador->getEmail(),
                $jugador->getPhone()
        ));

    }


       #[Route('jugador/delete/{id}', name:'jugador_eliminar', methods:"DELETE")]
       public function delete(Player $jugador):Response{
           $this->entityManager->remove($jugador);
           $this->entityManager->flush();

           return $this->json(null,204);
       }


       #[Route('jugador/update/{id}', name:'jugador_actualizar', methods: "PUT")]
        public function update(Request $request, Player $jugador):Response{

              $data = json_decode($request->getContent(), true);

              $jugador->setDni('23456J');
              $jugador->setName('Marta');
              $jugador->setLast_name('Perez');
              $jugador->setTeam('Teis');
              $jugador->setSalary(rand(1000,2000));
              $jugador->setPosition('central');
              $jugador->setDorsal(rand(0,20));
              $jugador->setEmail('hsdikijdsfn');
              $jugador->setPhone('212342');

              $this->entityManager->flush();

              return new Response(sprintf(
                  'dni: %s nombre:%s apellidos: %s equipo: %s salario: %d posicion: %s dorsal: %d email: %s telefono: %s',
                      $jugador->getDni(),
                      $jugador->getName(),
                      $jugador->getLast_name(),
                      $jugador->getTeam(),
                      $jugador->getSalary(),
                      $jugador->getPosition(),
                      $jugador->getDorsal(),
                      $jugador->getEmail(),
                      $jugador->getPhone()
                  ));
       }


       #[Route('jugador/show/{id}', name:'jugador_mostrar',methods: "GET")]
        public function show(Player $jugador):Response{
                     return new Response(sprintf(
               'dni: %s nombre:%s apellidos: %s equipo: %s salario: %d posicion: %s dorsal: %d email: %s telefono: %s',
                   $jugador->getDni(),
                   $jugador->getName(),
                   $jugador->getLast_name(),
                   $jugador->getTeam(),
                   $jugador->getSalary(),
                   $jugador->getPosition(),
                   $jugador->getDorsal(),
                   $jugador->getEmail(),
                   $jugador->getPhone()
            ));
       }


}
