<?php

namespace App\Repository;

use App\Entity\ReservationEquipement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReservationEquipement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationEquipement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationEquipement[]    findAll()
 * @method ReservationEquipement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationEquipementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReservationEquipement::class);
    }
}
