<?php

declare (strict_types = 1);

namespace tests\TwitterHashtagFrequency\Projection;

use TwitterHashtagFrequency\HashtagProvider;
use TwitterHashtagFrequency\Projection\HashtagFrequencyProjection;
use TwitterHashtagFrequency\Projection\HashtagFrequencyView;

class HashtagFrequencyProjectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var HashtagProvider */
    private $provider;

    /** @var HashtagFrequencyProjection */
    private $projection;

    /** @test */
    public function it_returns_summary_of_hashtags_for_screen_name()
    {
        $this->givenThereAreHashtagsWithCount(
            'lzakrzewski_php',
            [
                'hashtag2' => 50,
                'hashtag1' => 100,
                'hashtag3' => 33,
            ]
        );

        $views = $this->projection->get('lzakrzewski_php');

        $this->assertEquals([
            new HashtagFrequencyView('hashtag1', 100),
            new HashtagFrequencyView('hashtag2', 50),
            new HashtagFrequencyView('hashtag3', 33),
        ], $views);
    }

    /** @test */
    public function it_returns_summary_of_hashtags_for_screen_name_without_tweets()
    {
        $this->givenThereAreHashtagsWithCount('lzakrzewski_php', []);

        $views = $this->projection->get('lzakrzewski_php');

        $this->assertEmpty($views);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->provider   = $this->prophesize(HashtagProvider::class);
        $this->projection = new HashtagFrequencyProjection($this->provider->reveal());
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->provider   = null;
        $this->projection = null;
    }

    private function givenThereAreHashtagsWithCount(string $screenName, array $hashtagInfo)
    {
        $hashtags = [];

        foreach ($hashtagInfo as $hashtag => $count) {
            for ($hashTagIdx = 0; $hashTagIdx < $count; ++$hashTagIdx) {
                $hashtags[] = $hashtag;
            }
        }

        shuffle($hashtags);

        $this->provider
            ->get($screenName)
            ->willReturn($hashtags);
    }
}
