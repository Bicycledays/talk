<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Member;
use App\Entity\Talk;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Talk|null find($id, $lockMode = null, $lockVersion = null)
 * @method Talk|null findOneBy(array $criteria, array $orderBy = null)
 * @method Talk[]    findAll()
 * @method Talk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TalkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Talk::class);
    }

    /**
     * @param Talk $entity
     * @param bool $flush
     */
    public function add(Talk $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Talk $entity
     * @param bool $flush
     */
    public function remove(Talk $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param User $user
     * @return array
     */
    public function identifiersByUser(User $user): array
    {
        $qb = $this->createQueryBuilder('t');
        $result = $qb
            ->select('t.id')
            ->leftJoin('t.members', 'm')
            ->leftJoin('m.talker', 'u')
            ->where('u.id = :id')
            ->setParameter('id', (int)$user->getId())
            ->getQuery()
            ->getResult();

        return array_column($result, 'id');
    }

    /**
     * Общий чат двух пользователей
     *
     * @param User $currentUser
     * @param User $profileUser
     * @return Talk|null
     */
    public function commonTalk(User $currentUser, User $profileUser): ?Talk
    {
        $qb = $this->createQueryBuilder('t');
        $talks = $qb
            ->leftJoin('t.members', 'm')
            ->leftJoin('m.talker', 'u')
            ->andWhere(
                $qb->expr()->in('u', ':users'),
                $qb->expr()->eq('t.amountMembers', 2),
            )
            ->setParameter('users', [$currentUser, $profileUser])
            ->getQuery()
            ->getResult();

        /** @var Talk $talk */
        foreach ($talks as $talk) {
            $members = $talk->getMembers()->filter(
                function (Member $member) use ($currentUser, $profileUser) {
                    return
                        ($member->getTalker() === $currentUser) or
                        ($member->getTalker() === $profileUser);
                }
            );

            if (count($members) === 2) {
                return $talk;
            }
        }

        return null;
    }

//    public function commonTalk(User $currentUser, User $profileUser): ?Talk
//    {
//        $subCurrent = $this->_em->createQueryBuilder();
//        $subCurrent
//            ->select('cmt.id')
//            ->leftJoin('cm.talk', 'cmt')
//            ->from(Member::class, 'cm')
//            ->where($subCurrent->expr()->eq('cm.talker', ':currentUser'))
//            ->setParameter('currentUser', $currentUser)
//            ->getDQL();
//
//        $subProfile = $this->_em->createQueryBuilder();
//        $subProfile
//            ->select('pmt.id')
//            ->leftJoin('cm.talk', 'pmt')
//            ->from(Member::class, 'pm')
//            ->where($subProfile->expr()->eq('pm.talker', ':profileUser'))
//            ->setParameter('profileUser', $profileUser)
//            ->getDQL();
//
//        $qb = $this->createQueryBuilder('t');
//        $talks = $qb
////            ->leftJoin('t.members', 'm')
////            ->leftJoin('m.talker', 'u')
//            ->andWhere(
////                $qb->expr()->('t.members', ':users'),
//                $qb->expr()->eq('t.amountMembers', 2),
//                $qb->expr()->eq($subCurrent, $subProfile),
//            )
////            ->setParameter('users', [$currentUser, $profileUser])
//            ->getQuery()
//            ->getOneOrNullResult();
//
//        return $talk;
//    }
}
