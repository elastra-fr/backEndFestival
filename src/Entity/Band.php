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
    private ?int $band_id = null;

    #[ORM\Column(length: 255)]
    private ?string $band_name = null;

    #[ORM\Column(name: "band_description", length: 255)]
    private ?string $band_description = null;

    #[ORM\Column(length: 255)]
    private ?string $url_image = null;

    #[ORM\ManyToOne(targetEntity: MusicStyle::class, inversedBy: 'bands')]
    #[ORM\JoinColumn(name: 'music_style_id', referencedColumnName: 'music_style_id', nullable: false)]
    private ?MusicStyle $music_style = null;

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
        return $this->band_id;
    }

    public function getBandName(): ?string
    {
        return $this->band_name;
    }

    public function setBandName(string $band_name): static
    {
        $this->band_name = $band_name;
        return $this;
    }

    public function getBandDescription(): ?string
    {
        return $this->band_description;
    }

    public function setBandDescription(string $band_description): static
    {
        $this->band_description = $band_description;
        return $this;
    }

    public function getUrlImage(): ?string
    {
        return $this->url_image;
    }

    public function setUrlImage(string $url_image): static
    {
        $this->url_image = $url_image;
        return $this;
    }

    public function getMusicStyle(): ?MusicStyle
    {
        return $this->music_style;
    }

    public function setMusicStyle(?MusicStyle $music_style): static
    {
        $this->music_style = $music_style;
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
            $concert->setBand($this); // Vérifiez ici que 'band' est la propriété dans Concert
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
