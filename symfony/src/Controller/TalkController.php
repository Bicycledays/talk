<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\TalkService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TalkController extends AbstractController
{
    /**
     * @Route("/talks", name="app_talk")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        return new JsonResponse(['username' => $user->getUsername()]);
    }

    public function talk(): Response
    {
        return $this->render('talk/index.html.twig');
    }

    /**
     * Получение сообщений пользователя для чата
     *
     * @param int $id
     * идентификатор чата
     * @param TalkService $service
     * @return JsonResponse
     */
    public function apiTalk(int $id, TalkService $service): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        return new JsonResponse(ResponseHelper::toArray());
    }

    /**
     * Получение всех чатов, в которых
     * есть пользователь
     *
     * @param TalkService $service
     * @return JsonResponse
     */
    public function talkIdentifiers(TalkService $service): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        ResponseHelper::$result = $service->identifiersByUser($user);

        return new JsonResponse(ResponseHelper::toArray());
    }
}
