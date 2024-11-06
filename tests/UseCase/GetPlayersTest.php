<?php

namespace App\Tests\UseCase;

use App\Infrastructure\Symfony\Command\GetPlayersCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class GetPlayersTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(GetPlayersCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute(array());
        $this->assertSame(Command::SUCCESS, $r);
    }
}