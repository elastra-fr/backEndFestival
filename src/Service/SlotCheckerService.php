<?php       
namespace App\Service;

use App\Entity\Concert;
use Doctrine\ORM\EntityManagerInterface;


class SlotCheckerService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

/**
 * Methode qui permet de vérifier si un créneau est déjà pris sur une même scène
 *
 * @param \DateTime $concertDateTime
 * @param integer $stageId
 * @return boolean
 */
    public function isSlotTaken(\DateTime $concertDateTime, 
    int $stageId): bool
    {
        $concertRepository = $this->entityManager->getRepository(Concert::class);
    
        // Remove minutes and seconds from the DateTime object
        $concertDateTime->setTime($concertDateTime->format('H'), 0, 0);
    
        $query = $concertRepository->createQueryBuilder('c')
            ->where('c.stage = :stageId')
            ->andWhere('c.concertDate = :concertDateTime')
            ->setParameter('stageId', $stageId)
            ->setParameter('concertDateTime', $concertDateTime)
            ->getQuery();
    
        $existingConcerts = $query->getResult();
    
        return !empty($existingConcerts);
    }



}
