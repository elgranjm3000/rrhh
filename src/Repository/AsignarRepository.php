<?php

namespace App\Repository;

use App\Entity\Asignar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Asignar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Asignar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Asignar[]    findAll()
 * @method Asignar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsignarRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Asignar::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
