<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpFormType;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AbstractController
{
    /**
     * @param string $hash
     * @param Request $request
     * @param AuthService $service
     * @return Response
     */
    public function signUp(
        string      $hash,
        Request     $request,
        AuthService $service
    ): Response
    {
        $invite = $service->checkInvite($hash);

        $user = new User();
        $form = $this->createForm(SignUpFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->signUp(
                $user,
                $invite,
                $form->get('plainPassword')->getData(),
            );
            return $this->redirectToRoute('sign-in');
        }

        return $this->render('auth/sign_up.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    public function signIn(Request $request): Response
    {
        return $this->render('auth/sign_in.html.twig');
    }
}
