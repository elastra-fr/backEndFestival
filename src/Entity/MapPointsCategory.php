<?php

namespace App\Entity;

use App\Repository\MapPointsCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MapPointsCategoryRepository::class)]
class MapPointsCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $PointCategory = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PointUrl = null;

    /**
     * @var Collection<int, MapPoint>
     */
    #[ORM\OneToMany(targetEntity: MapPoint::class, mappedBy: 'type')]
    private Collection $mapPoints;

    public function __construct()
    {
        $this->mapPoints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPointCategory(): ?string
    {
        return $this->PointCategory;
    }

    public function setPointCategory(string $PointCategory): static
    {
        $this->PointCategory = $PointCategory;

        return $this;
    }

    public function getPointUrl(): ?string
    {
        return $this->PointUrl;
    }

    public function setPointUrl(?string $PointUrl): static
    {
        $this->PointUrl = $PointUrl;

        return $this;
    }

    /**
     * @return Collection<int, MapPoint>
     */
    public function getMapPoints(): Collection
    {
        return $this->mapPoints;
    }

    public function addMapPoint(MapPoint $mapPoint): static
    {
        if (!$this->mapPoints->contains($mapPoint)) {
            $this->mapPoints->add($mapPoint);
            $mapPoint->setType($this);
        }

        return $this;
    }

    public function removeMapPoint(MapPoint $mapPoint): static
    {
        if ($this->mapPoints->removeElement($mapPoint)) {
            // set the owning side to null (unless already changed)
            if ($mapPoint->getType() === $this) {
                $mapPoint->setType(null);
            }
        }

        return $this;
    }
}
