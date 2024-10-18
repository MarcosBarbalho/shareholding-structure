<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PingController
{
    #[Route('/ping', name: 'ping', methods: ['GET'])]
    public function index(): Response
    {
        return new Response('pong');
    }
}
