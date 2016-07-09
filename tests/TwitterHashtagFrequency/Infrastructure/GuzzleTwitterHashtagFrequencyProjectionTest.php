<?php

declare (strict_types = 1);

namespace tests\TwitterHashtagFrequency\Infrastructure;

use GuzzleHttp\Client;
use TwitterHashtagFrequency\Infrastructure\GuzzleTwitterHashtagFrequencyProjection;

class GuzzleTwitterHashtagFrequencyProjectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var GuzzleTwitterHashtagFrequencyProjection */
    private $projection;

    /** @test */
    public function it_gets_twitter_keyword_frequency_views()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_gets_empty_when_no_tweets()
    {
        $views = $this->projection->get('twitterapi');

        $this->assertEmpty($views);
    }

    /** @test */
    public function if_fails_when_connection_failed()
    {
        $this->markTestIncomplete();
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->projection = new GuzzleTwitterHashtagFrequencyProjection(new Client());
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->projection = null;
    }
}
