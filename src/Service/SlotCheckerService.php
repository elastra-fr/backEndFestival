<?php       
namespace App\Service;

use App\Entity\Concert;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;


class SlotCheckerService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function isSlotTaken(\DateTime $concertDateTime, int $stageId): bool
    {
        $concertRepository = $this->entityManager->getRepository(Concert::class);
    
        // Remove minutes and seconds from the DateTime object
        $concertDateTime->setTime($concertDateTime->format('H'), 0, 0);
    
        $query = $concertRepository->createQueryBuilder('c')
            ->where('c.Stage = :stageId')
            ->andWhere('c.ConcertDate = :concertDateTime')
            ->setParameter('stageId', $stageId)
            ->setParameter('concertDateTime', $concertDateTime)
            ->getQuery();
    
        $existingConcerts = $query->getResult();
    
        return !empty($existingConcerts);
    }



}
