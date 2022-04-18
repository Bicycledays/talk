<?php
declare(strict_types=1);

namespace App\Service\Invite;

use App\Entity\Invite;
use App\Entity\User;
use App\Repository\InviteRepository;
use Exception;

class Generator
{
    protected InviteRepository $repository;

    public function __construct(InviteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param User $sender
     * @return Invite
     * @throws Exception
     */
    public function generate(User $sender): Invite
    {
        $hash = hash('sha256', (string)random_int(0, PHP_INT_MAX));
        $invite = (new Invite())
            ->setSender($sender)
            ->setHash($hash)
        ;
        $this->repository->add($invite);

        return $invite;
    }
}