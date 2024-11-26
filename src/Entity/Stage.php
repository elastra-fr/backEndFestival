<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "stage_id", type: 'integer' )]
    private ?int $stageId = null;

    #[ORM\Column(length: 255)]
    private ?string $stageName = null;



    /**
     * @var Collection<int, Concert>
     */
    #[ORM\OneToMany(targetEntity: Concert::class, mappedBy: 'Stage')]
    private Collection $concerts;

    public function __construct()
    {
        $this->concerts = new ArrayCollection();
    }

    public function getStageId(): ?int
    {
        return $this->stageId;
    }

    public function getStageName(): ?string
    {
        return $this->stageName;
    }

    public function setStageName(string $stageName): static
    {
        $this->stageName = $stageName;

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
            $concert->setStage($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): static
    {
        if ($this->concerts->removeElement($concert)) {
            // set the owning side to null (unless already changed)
            if ($concert->getStage() === $this) {
                $concert->setStage(null);
            }
        }

        return $this;
    }
}
