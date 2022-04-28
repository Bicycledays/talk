<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /** @return Response */
    public function profile(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    /**
     * @param int|null $id
     * @param UserService $service
     * @return JsonResponse
     */
    public function profileData(?int $id, UserService $service): JsonResponse
    {
        try {
            if ($id === null) {
                /** @var User $user */
                $user = $this->getUser();
                $template = '/profile/me.html.twig';
            } else {
                $user = $service->profileUser($id);
                $template = '/profile/user.html.twig';
            }
            $view = $this->renderView($template, ['user' => $user]);
            ResponseHelper::$result = ['view' => $view];
        } catch (\Exception $e) {
            ResponseHelper::badMessage($e->getMessage());
        }

        return new JsonResponse(ResponseHelper::toArray());
    }
}
