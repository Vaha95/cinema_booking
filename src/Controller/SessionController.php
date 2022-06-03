<?php

namespace App\Controller;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Form\BookingType;
use App\Domain\Booking\View\Factory\SessionViewFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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
        return $this->render('session/index.html.twig', [
            'sessions' => $this->sessionViewFactory->createByCollection($this->sessionRepository->findAllAgregate()),
        ]);
    }

    #[Route('/booking', name: 'app_booking')]
    public function booking(Request $request, MessageBusInterface $bus): Response
    {
        $command = new BookingCommand();
        $bookingForm = $this->createForm(BookingType::class, $command, [
            'csrf_protection' => false,
        ]);

        $bookingForm->submit($request->request->all());

        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
            $bus->dispatch($command);
            return $this->render('default/card_info.html.twig', [
                'title' => $command->name,
                'description' => $command->phone,
            ]);
        }

        return $this->render('default/card_info.html.twig', [
            'title' => 'Некорректные входные данные',
            'description' => '',
        ]);
    }
}
