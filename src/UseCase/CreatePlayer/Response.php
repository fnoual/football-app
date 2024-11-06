<?php

namespace App\UseCase\CreatePlayer;

use Symfony\Component\Uid\Uuid;

class Response
{
    public function __construct(private readonly Uuid $id)
    {
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }
}