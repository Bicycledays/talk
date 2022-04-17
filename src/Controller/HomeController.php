<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\TalkerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @param TalkerService $service
     * @return JsonResponse
     */
    public function getAllTalkers(TalkerService $service): JsonResponse
    {
        try {
            ResponseHelper::$result = $service->getAllTalkers();
        } catch (\Exception $e) {
            ResponseHelper::badMessage($e->getMessage());
        }

        return new JsonResponse(ResponseHelper::toArray());
    }
}
