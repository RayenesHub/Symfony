<?php

namespace App\Entity;
use DateTimeInterface;

use App\Repository\VoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $noteVote = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Joueur $JouerVote = null;

    #[ORM\Column]
    private ?float $moyenneVote = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getNoteVote(): ?int
    {
        return $this->noteVote;
    }

    public function setNoteVote(int $noteVote): static
    {
        $this->noteVote = $noteVote;

        return $this;
    }

    public function getJouerVote(): ?Joueur
    {
        return $this->JouerVote;
    }

    public function setJouerVote(?Joueur $JouerVote): static
    {
        $this->JouerVote = $JouerVote;

        return $this;
    }

    public function getMoyenneVote(): ?float
    {
        return $this->moyenneVote;
    }

    public function setMoyenneVote(float $moyenneVote): static
    {
        $this->moyenneVote = $moyenneVote;

        return $this;
    }
}
