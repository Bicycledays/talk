<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\TalkService;
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
     * @param UserService $userService
     * @param TalkService $talkService
     * @return JsonResponse
     */
    public function profileData(
        ?int        $id,
        UserService $userService,
        TalkService $talkService
    ): JsonResponse
    {
        try {
            /** @var User $currentUser */
            $currentUser = $this->getUser();

            if ($id === null) {
                $template = '/profile/me.html.twig';
                $view = $this->renderView($template, ['user' => $currentUser]);
            } else {
                $profileUser = $userService->profileUser($id);
                $commonTalk = $talkService->commonTalk($currentUser, $profileUser);
                $template = '/profile/user.html.twig';
                $view = $this->renderView($template, ['user' => $profileUser, 'talk' => $commonTalk]);
            }
            ResponseHelper::$result = ['view' => $view];
        } catch (\Exception $e) {
            ResponseHelper::badMessage($e->getMessage());
        }

        return new JsonResponse(ResponseHelper::toArray());
    }

    /**
     * @return JsonResponse
     */
    public function userId(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        ResponseHelper::$result = [
            'id' => $user->getId(),
            'username' => $user->getUsername()
        ];

        return new JsonResponse(ResponseHelper::toArray());
    }
}
