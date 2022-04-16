<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Invite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Invite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invite[]    findAll()
 * @method Invite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invite::class);
    }

    /**
     * @param Invite $entity
     * @param bool $flush
     */
    public function add(Invite $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Invite $entity
     * @param bool $flush
     */
    public function remove(Invite $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param string $hash
     * @return bool
     * true - приглашение действующее
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function isValid(string $hash): bool
    {
        $qb = $this->createQueryBuilder('i');
        $result = $qb
            ->select(
                $qb->expr()->count('i.id'),
                'count(i.id)'
            )
            ->andWhere(
                $qb->expr()->eq('i.hash', ':h')
            )
            ->setParameter(':h', $hash)
            ->getQuery()
            ->getSingleResult(AbstractQuery::HYDRATE_SINGLE_SCALAR)
            ;
        var_dump($result);
        die();
    }
}
