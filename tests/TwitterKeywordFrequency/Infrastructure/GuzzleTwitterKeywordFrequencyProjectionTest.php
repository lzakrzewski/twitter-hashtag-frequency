<?php

declare (strict_types = 1);

namespace tests\TwitterKeywordFrequency\Infrastructure;

use GuzzleHttp\Client;
use TwitterKeywordFrequency\Infrastructure\GuzzleTwitterKeywordFrequencyProjection;

class GuzzleTwitterKeywordFrequencyProjectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var GuzzleTwitterKeywordFrequencyProjection */
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
        $this->projection = new GuzzleTwitterKeywordFrequencyProjection(new Client());
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->projection = null;
    }
}
