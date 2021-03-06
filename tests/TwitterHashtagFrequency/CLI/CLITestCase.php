<?php

declare (strict_types = 1);

namespace tests\TwitterHashtagFrequency\CLI;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

abstract class CLITestCase extends \PHPUnit_Framework_TestCase
{
    /** @var CommandTester */
    private $tester;
    /**
     * @param Command $command
     * @param array   $parameters
     */
    protected function executeCommand(Command $command, $parameters = [])
    {
        $application = new Application();
        $application->add($command);

        $this->tester = new CommandTester($command);

        $parameters = array_merge(
            ['command' => $command->getName()],
            $parameters
        );

        $this->tester->execute($parameters);
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->tester = null;

        parent::tearDown();
    }

    protected function assertExitCode($expectedStatus)
    {
        $this->assertEquals($expectedStatus, $this->tester->getStatusCode());
    }
}
