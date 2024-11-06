<?php

namespace App\UseCase\GetPlayers;

use App\Domain\Repository\PlayerRepository;

final class UseCase
{
    public function __construct(private readonly PlayerRepository $playerRepository)
    {
    }

    public function execute(Request $request): Response
    {
        return new Response($this->playerRepository->findAll());
    }
}