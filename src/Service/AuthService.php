<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Invite;
use App\Entity\User;
use App\Repository\InviteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class AuthService
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $hash
     * @return bool
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function isValidInvoice(string $hash): bool
    {
        /** @var InviteRepository $repository */
        $repository = $this->em->getRepository(Invite::class);
        return $repository->isValid($hash);
    }

    public function signUp()
    {
        /** @var UserRepository $repository */
        $repository = $this->em->getRepository(User::class);
    }
}