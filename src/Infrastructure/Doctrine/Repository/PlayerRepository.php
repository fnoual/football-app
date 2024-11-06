<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository implements \App\Domain\Repository\PlayerRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function create(Player $player): void
    {
        $this->_em->persist($player);
        $this->_em->flush();
    }

    /**
     * @return Player[]
     */
    public function findAll(): array
    {
        return $this->findBy(array());
    }
}