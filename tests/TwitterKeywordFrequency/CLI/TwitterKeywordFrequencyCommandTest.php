<?php

declare (strict_types = 1);

namespace tests\TwitterKeywordFrequency\CLI;

use TwitterKeywordFrequency\CLI\TwitterKeywordFrequencyCommand;

class TwitterKeywordFrequencyCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testItExist()
    {
        $command = new TwitterKeywordFrequencyCommand();

        $this->assertInstanceOf(TwitterKeywordFrequencyCommand::class, $command);
    }
}
