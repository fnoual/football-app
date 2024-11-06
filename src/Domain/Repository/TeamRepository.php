<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Team;

interface TeamRepository
{
    public function save(Team $team): void;
    public function findByName(string $name): ?Team;
}
