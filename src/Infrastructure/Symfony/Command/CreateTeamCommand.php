<?php

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Exception\ValidationException;
use App\UseCase\CreateTeam\Request;
use App\UseCase\CreateTeam\UseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:team:create',
    description: 'Creates a new team with a specified name.'
)]
class CreateTeamCommand extends Command
{
    public const ARGUMENT_TEAM_NAME = 'name';

    public function __construct(private readonly UseCase $useCase)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(self::ARGUMENT_TEAM_NAME, InputArgument::REQUIRED, 'The name of the team.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $teamName = $input->getArgument(self::ARGUMENT_TEAM_NAME);

        // Validation for empty name
        if (empty(trim($teamName))) {
            $io->error('The team name cannot be empty.');
            return Command::FAILURE;
        }

        // Validation for name length
        if (strlen($teamName) > 255) {
            $io->error('Validation error: The team name cannot exceed 255 characters.');
            return Command::FAILURE;
        }

        try {
            $response = $this->useCase->execute(new Request($teamName));
            $io->success('Team has been created. ID: ' . $response->getTeam()->getId());
            return Command::SUCCESS;
        } catch (ValidationException $validationException) {
            $io->error('Validation error: ' . $validationException->getMessage());
            return Command::FAILURE;
        } catch (\Exception $exception) {
            $io->error('An unexpected error occurred: ' . $exception->getMessage());
            return Command::FAILURE;
        }
    }
}
