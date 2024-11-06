<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Team;
use App\Domain\Repository\TeamRepository as TeamRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class TeamRepository implements TeamRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Team $team): void
    {
        $this->entityManager->persist($team);
        $this->entityManager->flush();
    }

    public function findByName(string $name): ?Team
    {
        return $this->entityManager->getRepository(Team::class)->findOneBy(['name' => $name]);
    }

}
