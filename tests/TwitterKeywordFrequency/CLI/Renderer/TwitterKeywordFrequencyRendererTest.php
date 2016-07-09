<?php

declare (strict_types = 1);

namespace tests\TwitterKeywordFrequency\CLI\Renderer;

use Prophecy\Prophecy\ObjectProphecy;
use TwitterKeywordFrequency\Application\Projection\TwitterKeywordFrequencyProjection;
use TwitterKeywordFrequency\Application\Projection\TwitterKeywordFrequencyView;
use TwitterKeywordFrequency\CLI\Renderer\TwitterKeywordFrequencyRenderer;

class TwitterKeywordFrequencyRendererTest extends RendererTestCase
{
    /** @var TwitterKeywordFrequencyRenderer */
    private $renderer;

    /** @var TwitterKeywordFrequencyProjection|ObjectProphecy */
    private $projection;

    /** @test */
    public function it_renders_list_of_keywords_with_count()
    {
        $this->projection
            ->get('someAccount')
            ->willReturn([
                new TwitterKeywordFrequencyView('keyword1', 100),
                new TwitterKeywordFrequencyView('keyword2', 34),
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

        $this->projection = $this->prophesize(TwitterKeywordFrequencyProjection::class);
        $this->renderer   = new TwitterKeywordFrequencyRenderer($this->projection->reveal());
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->projection = null;
        $this->renderer   = null;

        parent::tearDown();
    }
}
