<?php

namespace App\Entity;

use App\Repository\ConcertRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConcertRepository::class)]
class Concert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'concerts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Band $Artist = null;

    #[ORM\ManyToOne(inversedBy: 'concerts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $Stage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ConcertDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtist(): ?Band
    {
        return $this->Artist;
    }

    public function setArtist(?Band $Artist): static
    {
        $this->Artist = $Artist;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->Stage;
    }

    public function setStage(?Stage $Stage): static
    {
        $this->Stage = $Stage;

        return $this;
    }

    public function getConcertDate(): ?\DateTimeInterface
    {
        return $this->ConcertDate;
    }

    public function setConcertDate(\DateTimeInterface $ConcertDate): static
    {
        $this->ConcertDate = $ConcertDate;

        return $this;
    }
}
