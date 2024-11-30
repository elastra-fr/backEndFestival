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
    #[ORM\Column(name: "map_point_category_id", type: "integer")]
    #[ORM\GeneratedValue]
    private ?int $mapPointCategoryId = null;

    #[ORM\Column(name: "map_point_category_name", type: "string", length: 50)]
    private ?string $mapPointCategoryName = null;

    #[ORM\Column(name: "map_point_icon_url", type: "string", length: 255, nullable: true)]
    private ?string $mapPointIconUrl = null;

    /**
     * @var Collection<int, MapPoint>
     */
    #[ORM\OneToMany(targetEntity: MapPoint::class, mappedBy: 'mapPointCategory')]
    private Collection $mapPoints;

    public function __construct()
    {
        $this->mapPoints = new ArrayCollection();
    }

    public function getMapPointCategoryId(): ?int
    {
        return $this->mapPointCategoryId;
    }

    public function getMapPointCategoryName(): ?string
    {
        return $this->mapPointCategoryName;
    }

    public function setMapPointCategoryName(string $mapPointCategoryName): self
    {
        $this->mapPointCategoryName = $mapPointCategoryName;

        return $this;
    }

    public function getMapPointIconUrl(): ?string
    {
        return $this->mapPointIconUrl;
    }

    public function setMapPointIconUrl(?string $mapPointIconUrl): self
    {
        $this->mapPointIconUrl = $mapPointIconUrl;

        return $this;
    }

    /**
     * @return Collection<int, MapPoint>
     */
    public function getMapPoints(): Collection
    {
        return $this->mapPoints;
    }

    public function addMapPoint(MapPoint $mapPoint): self
    {
        if (!$this->mapPoints->contains($mapPoint)) {
            $this->mapPoints->add($mapPoint);
            $mapPoint->setMapPointCategory($this);  
        }

        return $this;
    }

    public function removeMapPoint(MapPoint $mapPoint): self
    {
        if ($this->mapPoints->removeElement($mapPoint)) {
            if ($mapPoint->getMapPointCategory() === $this) {
                $mapPoint->setMapPointCategory(null);
            }
        }

        return $this;
    }
}
