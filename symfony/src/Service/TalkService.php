<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Member;
use App\Entity\Talk;
use App\Entity\User;
use App\Repository\MemberRepository;
use App\Repository\TalkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class TalkService
{
    protected TalkRepository $repository;
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, TalkRepository $repository)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * Идентификаторы всех чатов, в которых есть $user
     *
     * @param User $user
     * @return int[]
     */
    public function identifiersByUser(User $user): array
    {
        return $this->repository->identifiersByUser($user);
    }

    /**
     * Возвращает общий чат двух пользователей
     *
     * @param User $currentUser
     * @param User $profileUser
     * @return Talk
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function commonTalk(User $currentUser, User $profileUser): Talk
    {
        $talk = $this->repository->commonTalk($currentUser, $profileUser);
        if ($talk instanceof Talk) {
            return $talk;
        }

        return $this->createCommonTalk($currentUser, $profileUser);
    }

    /**
     * Создает общий чат для двух пользователей
     *
     * @param User $user1
     * @param User $user2
     * @return Talk
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createCommonTalk(User $user1, User $user2): Talk
    {
        /** @var MemberRepository $memberRepository */
        $memberRepository = $this->em->getRepository(Member::class);

        $member1 = (new Member())->setTalker($user1);
        $memberRepository->add($member1, false);

        $member2 = (new Member())->setTalker($user2);
        $memberRepository->add($member2, false);

        $talk = (new Talk())
            ->addMember($member1)
            ->addMember($member2);

        $this->repository->add($talk);
        return $talk;
    }
}