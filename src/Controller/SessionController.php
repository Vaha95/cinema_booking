<?php

namespace App\Controller;

use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\View\Factory\SessionViewFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    private EntityRepository $sessionRepository;

    public function __construct(EntityManagerInterface $entityManager, private SessionViewFactory $sessionViewFactory)
    {
        $this->sessionRepository = $entityManager->getRepository(Session::class);
    }

    #[Route('/', name: 'app_session')]
    public function index(): Response
    {
        return $this->render('Session/index.html.twig', [
            'sessions' => $this->sessionViewFactory->createByCollection($this->sessionRepository->findAllAgregate()),
        ]);
    }
}
