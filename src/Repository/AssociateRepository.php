<?php

namespace App\Repository;

use App\Entity\Associate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Associate>
 */
class AssociateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Associate::class);
    }

    /**
     * @return Associate[] Returns an array of Associate objects
     */
    public function findByOrganizationId(int $organizationId): array
    {
        return $this->createQueryBuilder('associate')
            ->andWhere('associate.organization = :organization')
            ->setParameter('organization', $organizationId)
            ->orderBy('associate.id', 'ASC')
            ->setMaxResults(25)
            ->getQuery()
            ->getResult();
    }

    public function findOneByOrganizationId(int $organizationId, int $associateId): ?Associate
    {
        return $this->createQueryBuilder('associate')
            ->andWhere('associate.organization = :organization')
            ->andWhere('associate.id = :associate')
            ->setParameter('organization', $organizationId)
            ->setParameter('associate', $associateId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
