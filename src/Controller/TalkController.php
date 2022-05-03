<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Talk;
use App\Entity\User;
use App\Repository\TalkRepository;
use App\Service\TalkService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @param int $id
     * @param TalkRepository $repository
     * @return JsonResponse
     */
    public function apiTalk(int $id, TalkRepository $repository): JsonResponse
    {
        $talk = $repository->find($id);
        if (!$talk instanceof Talk) {
            throw new NotFoundHttpException();
        }

        $view = $this->renderView('talk/talk.html.twig', ['talk' => $talk]);
        ResponseHelper::$result = ['view' => $view];

        return new JsonResponse(ResponseHelper::toArray());
    }

    /**
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
