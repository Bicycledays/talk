<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /** @return Response */
    public function profile(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    /**
     * @param int $id
     * @param Request $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function profileData(int $id, Request $request, UserRepository $repository): JsonResponse
    {
        try {
            $user = $repository->find($id ?? 0);
            if (!$user instanceof User) {
                throw new \Exception("Пользователь не найден");
            } elseif ($user === $this->getUser()) {
                // todo форма профиля
                ResponseHelper::$result = ['view' => 'у ля ля'];
            } else {
                $view = $this->renderView(
                    '/profile/user.html.twig',
                    ['user' => $user]
                );
                ResponseHelper::$result = ['view' => $view];
            }
        } catch (\Exception $e) {
            ResponseHelper::badMessage($e->getMessage());
        }

        return new JsonResponse(ResponseHelper::toArray());
    }
}
