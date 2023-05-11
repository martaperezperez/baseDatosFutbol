<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player extends Club
{


 

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 11)]
    private ?string $dni = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 40)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $team = null;

    #[ORM\Column]
    private ?float $salary = null;

    #[ORM\Column(length: 20)]
    private ?string $position = null;

    #[ORM\Column]
    private ?int $dorsal = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $phone = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Club $ClubId = null;

    #[ORM\ManyToOne(inversedBy: 'ClubId')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Club $club = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(string $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDorsal(): ?int
    {
        return $this->dorsal;
    }

    public function setDorsal(int $dorsal): self
    {
        $this->dorsal = $dorsal;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }


    public static function loadValidatorMetadata(ClassMetadata $metadata){
        $metadata->addConstraint(new UniqueEntity([
            'fields'=>'dni',
            'message'=>'The dni is already exists'
        ]))
            ->addConstraint(new UniqueEntity([
                'fields'=>'email',
                'message'=>'The email is already exists'
            ]))
            ->addConstraint(new UniqueEntity([
                'fields'=>'phone',
                'message'=>'The phone is already exists'
            ]));
    }

    public function getClubId(): ?Club
    {
        return $this->ClubId;
    }

    public function setClubId(?Club $ClubId): self
    {
        $this->ClubId = $ClubId;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }
}
