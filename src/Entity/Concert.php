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
    #[ORM\Column (name: "concert_id", type: "integer")]
    private ?int $concertId = null;

    // La relation ManyToOne avec Band
    #[ORM\ManyToOne(targetEntity: Band::class, inversedBy: 'concerts')]
    #[ORM\JoinColumn(name: 'band_id', referencedColumnName: 'band_id', nullable: false)]  // Précision de la colonne
    private ?Band $band = null;

    // La relation ManyToOne avec Stage
    #[ORM\ManyToOne(targetEntity: Stage::class, inversedBy: 'concerts')]
    #[ORM\JoinColumn(name:'stage_id', referencedColumnName: 'stage_id',nullable: false)] // Lier avec la table Stage
    private ?Stage $stage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $concertDate = null;

    // Getters et Setters

    public function getConcertId(): ?int
    {
        return $this->concertId;
    }

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(?Band $band): static
    {
        $this->band = $band;
        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): static
    {
        $this->stage = $stage;
        return $this;
    }

    public function getConcertDate(): ?\DateTimeInterface
    {
        return $this->concertDate;
    }

    public function setConcertDate(\DateTimeInterface $concertDate): static
    {
        $this->concertDate = $concertDate;
        return $this;
    }
}
