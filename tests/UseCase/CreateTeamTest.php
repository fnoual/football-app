<?php

namespace App\Tests\UseCase;

use App\Infrastructure\Symfony\Command\CreateTeamCommand;
use App\Infrastructure\Doctrine\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CreateTeamTest extends KernelTestCase
{
    private CommandTester $commandTester;
    private TeamRepository $teamRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreateTeamCommand::getDefaultName());
        $this->commandTester = new CommandTester($command);

        $this->teamRepository = self::getContainer()->get(TeamRepository::class);
    }

    public function testSuccessWithValidName(): void
    {
        $this->commandTester->execute([
            CreateTeamCommand::ARGUMENT_TEAM_NAME => 'MyTeam'
        ]);

        $this->assertSame(Command::SUCCESS, $this->commandTester->getStatusCode());

        $team = $this->teamRepository->findByName('MyTeam');
        $this->assertNotNull($team);
    }

    public function testFailureWithEmptyName(): void
    {
        $this->commandTester->execute([
            CreateTeamCommand::ARGUMENT_TEAM_NAME => ''
        ]);

        $this->assertSame(Command::FAILURE, $this->commandTester->getStatusCode());

        $team = $this->teamRepository->findByName('');
        $this->assertNull($team);
    }

    public function testFailureWithLongName(): void
    {
        $longName = str_repeat('a', 256);
        $this->commandTester->execute([
            CreateTeamCommand::ARGUMENT_TEAM_NAME => $longName
        ]);

        $this->assertSame(Command::FAILURE, $this->commandTester->getStatusCode());

        $team = $this->teamRepository->findByName($longName);
        $this->assertNull($team);
    }
}
