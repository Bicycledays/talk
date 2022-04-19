<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\Invite\Generator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class InviteController extends AbstractController
{
    /**
     * @Route("/api/invite-create", name="app_invite")
     */
    public function createInvite(Generator $generator): JsonResponse
    {
        try {
            /** @var User $user */
            $user = $this->getUser();
            ResponseHelper::$result = ['url' => $generator->generate($user)];
        } catch (\Exception $e) {
            ResponseHelper::badMessage($e->getMessage());
        }

        return new JsonResponse(ResponseHelper::toArray());
    }
}
