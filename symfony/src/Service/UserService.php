<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     * @return User
     * @throws Exception
     */
    public function profileUser(int $id): User
    {
        $user = $this->userRepository->find($id);

        if (!$user instanceof User)
            throw new Exception("Пользователь не существует");

        return $user;
    }

    /**
     * @return array<int, string[]>
     */
    public function allUsers(): array
    {
        return $this->userRepository->allUsers();
    }
}