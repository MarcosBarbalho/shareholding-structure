<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PingController extends AbstractController
{
    #[Route('/ping', name: 'ping', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json(['pong']);
    }
}
