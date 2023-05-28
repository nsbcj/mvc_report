<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatsRepository::class)]
class Stats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $hands = null;

    #[ORM\Column(nullable: true)]
    private ?int $wins = null;

    #[ORM\Column(nullable: true)]
    private ?int $ties = null;

    #[ORM\Column]
    private ?int $totalbet = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalreturn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHands(): ?int
    {
        return $this->hands;
    }

    public function setHands(int $hands): self
    {
        $this->hands = $hands;

        return $this;
    }

    public function getWins(): ?int
    {
        return $this->wins;
    }

    public function setWins(?int $wins): self
    {
        $this->wins = $wins;

        return $this;
    }

    public function getTies(): ?int
    {
        return $this->ties;
    }

    public function setTies(?int $ties): self
    {
        $this->ties = $ties;

        return $this;
    }

    public function getTotalbet(): ?int
    {
        return $this->totalbet;
    }

    public function setTotalbet(int $totalbet): self
    {
        $this->totalbet = $totalbet;

        return $this;
    }

    public function getTotalreturn(): ?int
    {
        return $this->totalreturn;
    }

    public function setTotalreturn(?int $totalreturn): self
    {
        $this->totalreturn = $totalreturn;

        return $this;
    }
}
