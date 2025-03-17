<?php

declare(strict_types=1);

namespace Tests\App\Helpers\Symfony;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @mixin Symfony
 */
trait Console
{
    public function runSymfonyConsoleCommand(string $command, array $parameters = [], array $consoleInputs = [], int $expectedExitCode = 0): string
    {
        $application = new Application($this->getService('kernel'));
        $consoleCommand = $application->find($command);
        $commandTester = new CommandTester($consoleCommand);
        $commandTester->setInputs($consoleInputs);

        $parameters = ['command' => $command] + $parameters;
        $exitCode = $commandTester->execute($parameters);
        $output = $commandTester->getDisplay();

        $this->assertSame(
            $expectedExitCode,
            $exitCode,
            'Command did not exit with code '.$expectedExitCode
            .' but with '.$exitCode.': '.$output
        );

        return $output;
    }
}