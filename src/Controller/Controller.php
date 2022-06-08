<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller extends AbstractController
{
    protected function renderCardByExceptions(\Throwable $exception, string $title): Response
    {
        return $this->renderResponse($title, $exception->getMessage() ?? '');
    }

    protected function renderInfoCard(string $title, string $description = ''): Response
    {
        return $this->renderResponse($title, $description);
    }

    private function renderResponse(string $title, string $description): Response
    {
        return $this->render('default/card_info.html.twig', [
            'title' => $title,
            'description' => $description,
        ]);
    }
}