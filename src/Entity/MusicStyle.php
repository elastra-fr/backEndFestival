<?php
namespace App\Entity;

use App\Repository\MusicStyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicStyleRepository::class)]
class MusicStyle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "music_style_id", type: "integer")]
    private ?int $musicStyleId = null;

    #[ORM\Column(length: 100)]
    private ?string $musicStyleName = null;

    /**
     * @var Collection<int, Band>
     */
    #[ORM\OneToMany(targetEntity: Band::class, mappedBy: 'music_style')]
    private Collection $bands;

    public function __construct()
    {
        $this->bands = new ArrayCollection();
    }

    public function getMusicStyleId(): ?int
    {
        return $this->musicStyleId;
    }

    public function getMusicStyleName(): ?string
    {
        return $this->musicStyleName;
    }

    public function setMusicStyleName(string $musicStyleName): static
    {
        $this->musicStyleName = $musicStyleName;
        return $this;
    }

    /**
     * @return Collection<int, Band>
     */
    public function getBands(): Collection
    {
        return $this->bands;
    }

    public function addBand(Band $band): static
    {
        if (!$this->bands->contains($band)) {
            $this->bands->add($band);
            $band->setMusicStyle($this);
        }
        return $this;
    }

    public function removeBand(Band $band): static
    {
        if ($this->bands->removeElement($band)) {
            if ($band->getMusicStyle() === $this) {
                $band->setMusicStyle(null);
            }
        }
        return $this;
    }
}