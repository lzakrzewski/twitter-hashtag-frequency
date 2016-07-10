<?php

declare (strict_types = 1);

namespace tests\TwitterHashtagFrequency\Infrastructure;

use GuzzleHttp\Client;
use TwitterHashtagFrequency\HashtagProviderFailed;
use TwitterHashtagFrequency\Infrastructure\GuzzleHashtagProvider;

class GuzzleHashtagProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var GuzzleHashtagProvider */
    private $provider;

    /** @test */
    public function it_hashtags_for_screen_name()
    {
        $hashtags = $this->provider->get('twitterapi');

        $this->assertNotEmpty($hashtags);
    }

    /** @test */
    public function it_gets_empty_when_no_hashtags_for_screen_name()
    {
        $hashtags = $this->provider->get('EMvLa9mCJGnFvxp');

        $this->assertEmpty($hashtags);
    }

    /** @test */
    public function if_fails_when_unable_to_get_hashtags()
    {
        $this->expectException(HashtagProviderFailed::class);

        $this->provider->get('not-existing-xyz');
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->provider = new GuzzleHashtagProvider(new Client());
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->provider = null;
    }
}
