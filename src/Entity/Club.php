<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
class Club
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $budget = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $phone = null;

    #[ORM\OneToMany(mappedBy: 'ClubId', targetEntity: Player::class)]
    private Collection $players;

    #[ORM\OneToMany(mappedBy: 'club', targetEntity: Player::class)]
    private Collection $ClubId;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->ClubId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

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
            'fields'=>'name',
            'message'=>'The name is already exists'
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

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setClubId($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getClubId() === $this) {
                $player->setClubId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getClubId(): Collection
    {
        return $this->ClubId;
    }

    public function addClubId(Player $clubId): self
    {
        if (!$this->ClubId->contains($clubId)) {
            $this->ClubId->add($clubId);
            $clubId->setClub($this);
        }

        return $this;
    }

    public function removeClubId(Player $clubId): self
    {
        if ($this->ClubId->removeElement($clubId)) {
            // set the owning side to null (unless already changed)
            if ($clubId->getClub() === $this) {
                $clubId->setClub(null);
            }
        }

        return $this;
    }


}
