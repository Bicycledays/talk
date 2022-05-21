<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @param UserService $service
     * @return JsonResponse
     */
    public function allUsers(UserService $service): JsonResponse
    {
        try {
            ResponseHelper::$result = $service->allUsers();
        } catch (\Exception $e) {
            ResponseHelper::badMessage($e->getMessage());
        }

        return new JsonResponse(ResponseHelper::toArray());
    }
}
