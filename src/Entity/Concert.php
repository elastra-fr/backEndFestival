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

    public function getId(): ?int
    {
        return $this->id;
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
