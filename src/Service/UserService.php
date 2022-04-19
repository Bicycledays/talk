<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array<int, string[]>
     */
    public function allUsers(): array
    {
        return $this->userRepository->allUsers();
    }
}