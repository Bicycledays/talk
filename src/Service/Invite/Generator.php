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
    protected string $host;

    public function __construct(string $host, InviteRepository $repository)
    {
        $this->host = $host;
        $this->repository = $repository;
    }

    /**
     * @param User $sender
     * @return string
     * Ссылка
     * @throws Exception
     */
    public function generate(User $sender): string
    {
        $hash = hash('sha256', (string)random_int(0, PHP_INT_MAX));
        $invite = (new Invite())
            ->setSender($sender)
            ->setHash($hash)
        ;
        $this->repository->add($invite);

        return $this->url($invite);
    }

    /**
     * @param Invite $invite
     * @return string
     */
    public function url(Invite $invite): string
    {
        /** @var string $hash */
        $hash = $invite->getHash();

        return sprintf(
            "%s/sign-up/%s",
            $this->host,
            $hash
        );
    }
}