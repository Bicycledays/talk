<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Invite;
use App\Entity\User;
use App\Repository\InviteRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    protected UserRepository $repository;
    protected EntityManagerInterface $em;
    protected JWTTokenManagerInterface $manager;
    protected UserPasswordHasherInterface $hasher;

    public function __construct(
        UserRepository              $repository,
        EntityManagerInterface      $em,
        JWTTokenManagerInterface    $manager,
        UserPasswordHasherInterface $hasher
    )
    {
        $this->em = $em;
        $this->hasher = $hasher;
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @param string $hash
     * @return Invite
     */
    public function checkInvite(string $hash): Invite
    {
        $invite = $this->getInvite($hash);

        /**
         * проверяем срок годности
         */
        $now = new DateTimeImmutable();
        $createdAt = $invite->getCreatedAt();

        if ($createdAt instanceof DateTimeImmutable &&
            $now->diff($createdAt)->days < Invite::TOTAL_LIFE_TIME
        ) {
            return $invite;
        }

        throw new NotFoundHttpException();
    }

    /**
     * @param string $hash
     * @return Invite
     */
    protected function getInvite(string $hash): Invite
    {
        /** @var InviteRepository $repository */
        $repository = $this->em->getRepository(Invite::class);
        $invite = $repository->findOneBy([
            'hash' => $hash,
            'newUser' => null
        ]);

        if (!$invite instanceof Invite) {
            throw new NotFoundHttpException();
        }

        return $invite;
    }

    /**
     * @param User $user
     * @param Invite $invite
     * @param string $plainPassword
     * @return void
     */
    public function signUp(
        User   $user,
        Invite $invite,
        string $plainPassword
    ): void
    {
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $plainPassword
            )
        );

        $this->repository->add($user, $invite);
    }
}
