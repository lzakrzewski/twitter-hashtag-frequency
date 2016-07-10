<?php

declare (strict_types = 1);

namespace tests\TwitterHashtagFrequency\CLI;

use tests\fixtures\FakeHashtagProvider;
use TwitterHashtagFrequency\CLI\HashtagFrequencyCommand;

class HashtagFrequencyCommandTest extends CLITestCase
{
    /** @test */
    public function it_returns_0_exit_code_when_successful()
    {
        $this->executeCommand($this->command(), ['screenName' => 'test-account']);

        $this->assertExitCode(0);
    }

    /** @test */
    public function it_returns_error_exit_code_when_no_required_argument()
    {
        $this->expectException(\RuntimeException::class);

        $this->executeCommand($this->command(), []);
    }

    /** @test */
    public function it_returns_error_exit_code_when_projection_failed()
    {
        $this->executeCommand($this->command(), ['screenName' => 'something-is-wrong']);

        $this->assertExitCode(1);
    }

    private function command()
    {
        return new HashtagFrequencyCommand(new FakeHashtagProvider());
    }
}
