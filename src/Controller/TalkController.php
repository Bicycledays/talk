<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TalkController extends AbstractController
{
    /**
     * @Route("/talk", name="app_talk")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        return new JsonResponse(['username' => $user->getUsername()]);
    }
}
