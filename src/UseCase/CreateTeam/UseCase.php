<?php

namespace App\UseCase\CreateTeam;

use App\Domain\Repository\TeamRepository;
use App\Domain\Entity\Team;

class UseCase
{
    private TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function execute(Request $request): Response
    {
        if ($this->teamRepository->findByName($request->getName()) !== null) {
            throw new \InvalidArgumentException("Une équipe avec ce nom existe déjà.");
        }

        $team = new Team($request->getName());
        $this->teamRepository->save($team);

        return new Response($team);
    }
}
