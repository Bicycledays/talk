<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class TalkerService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array<int, string[]>
     */
    public function getAllTalkers(): array
    {
        return $this->userRepository->getTalkers();
    }
}