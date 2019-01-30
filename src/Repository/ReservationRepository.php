<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    /**
     * ReservationRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getArchivesToDelete()
    {
        $cleaningDate = new \DateTime();
        $cleaningDate->sub(new \DateInterval('P3M'));

        $qb=$this->createQueryBuilder('r')
            ->where('r.endDate <= :date')
            ->setParameter('date', $cleaningDate->format('Y-m-d'))
            ->getQuery();

        $results = $qb->getResult();

        return $results;
    }
}
