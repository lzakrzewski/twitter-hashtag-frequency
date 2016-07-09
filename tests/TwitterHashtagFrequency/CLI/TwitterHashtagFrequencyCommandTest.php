<?php

declare (strict_types = 1);

namespace tests\TwitterHashtagFrequency\CLI;

use TwitterHashtagFrequency\CLI\TwitterHashtagFrequencyCommand;

class TwitterHashtagFrequencyCommandTest extends CLITestCase
{
    /** @test */
    public function it_returns_0_exit_code_when_successful()
    {
        $this->executeCommand(new TwitterHashtagFrequencyCommand(), ['account' => 'test-account']);

        $this->assertExitCode(0);
    }

    /** @test */
    public function it_returns_error_exit_code_when_no_required_argument()
    {
        $this->expectException(\RuntimeException::class);

        $this->executeCommand(new TwitterHashtagFrequencyCommand(), []);
    }

    /** @test */
    public function it_returns_error_exit_code_when_projection_failed()
    {
        $this->executeCommand(new TwitterHashtagFrequencyCommand(), ['account' => 'something-is-wrong']);

        $this->assertExitCode(1);
    }
}
