<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BandRepository::class)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "band_id", type: "integer")]
    private ?int $bandId = null;

    #[ORM\Column(length: 100)]
    private ?string $bandName = null;

    #[ORM\Column(name: "band_description", length: 100)]
    private ?string $bandDescription = null;

    #[ORM\Column(length: 255)]
    private ?string $bandImage = null;

    #[ORM\ManyToOne(targetEntity: MusicStyle::class, inversedBy: 'bands')]
    #[ORM\JoinColumn(name: 'music_style_id', referencedColumnName: 'music_style_id', nullable: false)]
    private ?MusicStyle $musicStyle = null;

    /**
     * @var Collection<int, Concert>
     */
    #[ORM\OneToMany(targetEntity: Concert::class, mappedBy: 'band')]
    private Collection $concerts;

    public function __construct()
    {
        $this->concerts = new ArrayCollection();
    }

    public function getBandId(): ?int
    {
        return $this->bandId;
    }

    public function getBandName(): ?string
    {
        return $this->bandName;
    }

    public function setBandName(string $bandName): static
    {
        $this->bandName = $bandName;
        return $this;
    }

    public function getBandDescription(): ?string
    {
        return $this->bandDescription;
    }

    public function setBandDescription(string $band_description): static
    {
        $this->bandDescription = $band_description;
        return $this;
    }

    public function getBandImage(): ?string
    {
        return $this->bandImage;
    }

    public function setBandImage(string $bandImage): static
    {
        $this->bandImage = $bandImage;
        return $this;
    }

    public function getMusicStyle(): ?MusicStyle
    {
        return $this->musicStyle;
    }

    public function setMusicStyle(?MusicStyle $music_style): static
    {
        $this->musicStyle = $music_style;
        return $this;
    }

    /**
     * @return Collection<int, Concert>
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): static
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts->add($concert);
            $concert->setBand($this);
        }
        return $this;
    }

    public function removeConcert(Concert $concert): static
    {
        if ($this->concerts->removeElement($concert)) {
            if ($concert->getBand() === $this) {
                $concert->setBand(null);
            }
        }
        return $this;
    }
}
