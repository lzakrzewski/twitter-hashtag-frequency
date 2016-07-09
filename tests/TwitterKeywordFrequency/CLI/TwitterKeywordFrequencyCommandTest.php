<?php

declare (strict_types = 1);

namespace tests\TwitterKeywordFrequency\CLI;

use TwitterKeywordFrequency\CLI\TwitterKeywordFrequencyCommand;

class TwitterKeywordFrequencyCommandTest extends CLITestCase
{
    /** @test */
    public function it_returns_0_exit_code_when_successful()
    {
        $this->executeCommand(new TwitterKeywordFrequencyCommand(), ['account' => 'test-account']);

        $this->assertExitCode(0);
    }

    /** @test */
    public function it_returns_error_exit_code_when_no_required_argument()
    {
        $this->expectException(\RuntimeException::class);

        $this->executeCommand(new TwitterKeywordFrequencyCommand(), []);
    }

    /** @test */
    public function it_returns_error_exit_code_when_projection_failed()
    {
        $this->executeCommand(new TwitterKeywordFrequencyCommand(), ['account' => 'something-is-wrong']);

        $this->assertExitCode(1);
    }
}
