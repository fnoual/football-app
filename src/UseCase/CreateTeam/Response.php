<?php

namespace App\UseCase\CreateTeam;

use App\Domain\Entity\Team;

class Response
{
    private Team $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }
}
