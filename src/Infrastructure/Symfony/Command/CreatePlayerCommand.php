<?php

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Exception\ValidationException;
use App\UseCase\CreatePlayer\Request;
use App\UseCase\CreatePlayer\UseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: 'Creates a new player.',
    hidden: false
)]
final class CreatePlayerCommand extends Command
{
    public const COMMAND_NAME = "app:player:create";
    public const ARGUMENT_PLAYER_NAME = 'name';

    public function __construct(private readonly UseCase $useCase)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(self::ARGUMENT_PLAYER_NAME, InputArgument::REQUIRED, 'The name of the player.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);
        try {
            $response = $this->useCase->execute(new Request($input->getArgument(self::ARGUMENT_PLAYER_NAME)));
        } catch (ValidationException $validation) {
            $io->error($validation->getMessage());
            return Command::FAILURE;
        }
        $io->success('Player has been created. Id is : ' . $response->getId());
        return Command::SUCCESS;
    }
}