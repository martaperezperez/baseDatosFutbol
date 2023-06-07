<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Form\CoachType;
use App\Helper\FormErrorsToArray;
use App\Repository\CoachRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

class coachController extends AbstractController
{


    private $entityManager;

    private $coachRepository;
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, CoachRepository $coachRepository, MailerInterface $mailer){
        $this->mailer=$mailer;
        $this->entityManager=$entityManager;
        $this->coachRepository=$coachRepository;

    }


    #[Route('coach', name:'coach_index', methods:"GET")]
    #[OA\Get(path: '/coach', tags: ['Coach'])]
    public function index():Response{

      $coachs = $this->coachRepository->findAll();
      $data= [];

       foreach ($coachs as $coach){
           $id= $coach->getId();
           $dni= $coach->getDni();
           $name= $coach->getName();
           $lastname = $coach->getLastname();
           $team = $coach->getTeam();
           $salary = $coach->getSalary();
           $email = $coach->getEmail();
           $phone = $coach->getPhone();

           $data[]=[
             'id'=>$id,
             'dni'=>$dni,
             'name'=>$name,
             'last_name'=>$lastname,
             'team'=>$team,
             'salary'=>$salary,
             'email'=>$email,
             'phone'=>$phone,

           ];

       }
       return $this ->json(["Coachs"=>$data]);

    }

    #[Route('coach/create', name: 'coach_create', methods:"POST")]
    #[OA\Post(path: '/coach/create', tags: ['Coach'])]
    public function create(Request $request, CoachRepository $coachRepository): Response{

        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $coachRepository->save($coach, true);
            $email = (new Email())
                ->from('marta.perez@xilon.es')
                ->to($coach->getEmail())
                ->subject('Dar de Alta Coach')
                ->text('Has sido dado de alta como Coach ');
            $this->mailer->send($email);

            return new JsonResponse(['message' => 'Coach create successfully'], Response::HTTP_CREATED);

        }


        return new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)], Response::HTTP_BAD_REQUEST);

    }

    #[Route('coach/delete/{id}', name: 'coach_delete', methods:"DELETE")]
    #[OA\Delete(path: '/coach/delete/{id}', tags: ['Coach'])]
    public function delete(Coach $coach):Response{
        $this->entityManager->remove($coach);
        $this->entityManager->flush();

        $email = (new Email())
            ->from('marta.perez@xilon.es')
            ->to($coach->getEmail())
            ->subject('Dar de Baja Coach')
            ->text('Has sido dado de baja como Coach ');
        $this->mailer->send($email);


        return new JsonResponse(['message' => 'Coach successfully removed'], Response::HTTP_CREATED);
        //return $this->json(null, 204);


    }


    #[Route('coach/update/{id}', name: 'coach_update', methods: "PUT")]
    #[OA\Put(path: '/coach/update/{id}', tags: ['Coach'])]
    public function update(Request $request, Coach $coach, CoachRepository $coachRepository):Response{

        $form = $this->createForm(CoachType::class, $coach,["method"=>"PUT"]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $coach= $form->getData();
            $coachRepository->save($coach,true);
            return new JsonResponse(['message'=>'Coach update successfully'], Response::HTTP_CREATED);
        }

        return  new JsonResponse(['errors'=>FormErrorsToArray::staticParseErrorsToArray($form)],Response::HTTP_BAD_REQUEST);
    }

    #[Route('coach/show/{id}', name: 'coach_show', methods: "GET")]
    #[OA\Get(path: '/coach/show/{id}', tags: ['Coach'])]
    public function show(Coach $coach):Response{
        return $this->json(sprintf(
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
