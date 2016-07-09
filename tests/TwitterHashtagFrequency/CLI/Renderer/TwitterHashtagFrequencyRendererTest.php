<?php

declare (strict_types = 1);

namespace tests\TwitterHashtagFrequency\CLI\Renderer;

use Prophecy\Prophecy\ObjectProphecy;
use TwitterHashtagFrequency\Application\Projection\TwitterHashtagFrequencyProjection;
use TwitterHashtagFrequency\Application\Projection\TwitterHashtagFrequencyView;
use TwitterHashtagFrequency\CLI\Renderer\TwitterHashtagFrequencyRenderer;

class TwitterHashtagFrequencyRendererTest extends RendererTestCase
{
    /** @var TwitterHashtagFrequencyRenderer */
    private $renderer;

    /** @var TwitterHashtagFrequencyProjection|ObjectProphecy */
    private $projection;

    /** @test */
    public function it_renders_list_of_keywords_with_count()
    {
        $this->projection
            ->get('someAccount')
            ->willReturn([
                new TwitterHashtagFrequencyView('keyword1', 100),
                new TwitterHashtagFrequencyView('keyword2', 34),
            ]);

        $this->renderer->render('someAccount', $this->output());

        $this->assertThatDisplayContains('keyword1');
        $this->assertThatDisplayContains('keyword2');
        $this->assertThatDisplayContains('100');
        $this->assertThatDisplayContains('34');
    }

    /** @test */
    public function it_renders_empty_list_of_keywords()
    {
        $this->projection
            ->get('accountWithoutTweets')
            ->willReturn([]);

        $this->renderer->render('accountWithoutTweets', $this->output());

        $this->assertThatDisplayContains('There is no keywords for an account "accountWithoutTweets"');
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        parent::setUp();

        $this->projection = $this->prophesize(TwitterHashtagFrequencyProjection::class);
        $this->renderer   = new TwitterHashtagFrequencyRenderer($this->projection->reveal());
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->projection = null;
        $this->renderer   = null;

        parent::tearDown();
    }
}
