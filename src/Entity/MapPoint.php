<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class MapPoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $map_point_id = null;

    #[ORM\ManyToOne(targetEntity: MapPointsCategory::class, inversedBy: 'mapPoints')]
    #[ORM\JoinColumn(name: "map_point_category_id", referencedColumnName: "map_point_category_id", nullable: false)]
    private ?MapPointsCategory $mapPointCategory = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 7)]
    private ?string $longitude = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 7)]
    private ?string $latitude = null;

    #[ORM\Column(length: 100)]
    private ?string $map_point_title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $map_point_description = null;

    // Getter and Setter methods

    public function getId(): ?int
    {
        return $this->map_point_id;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getMapPointCategory(): ?MapPointsCategory
    {
        return $this->mapPointCategory;
    }

    public function setMapPointCategory(MapPointsCategory $mapPointsCategory): self
    {
        $this->mapPointCategory = $mapPointsCategory;
        return $this;
    }

    public function getMapPointTitle(): ?string
    {
        return $this->map_point_title;
    }

    public function setMapPointTitle(string $map_point_title): self
    {
        $this->map_point_title = $map_point_title;
        return $this;
    }

    public function getMapPointDescription(): ?string
    {
        return $this->map_point_description;
    }

    public function setMapPointDescription(?string $map_point_description): self
    {
        $this->map_point_description = $map_point_description;
        return $this;
    }
}
