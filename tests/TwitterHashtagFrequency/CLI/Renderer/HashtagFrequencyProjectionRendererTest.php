<?php

declare (strict_types = 1);

namespace tests\TwitterHashtagFrequency\CLI\Renderer;

use Prophecy\Prophecy\ObjectProphecy;
use TwitterHashtagFrequency\CLI\Renderer\HashtagFrequencyProjectionRenderer;
use TwitterHashtagFrequency\Projection\HashtagFrequencyProjection;
use TwitterHashtagFrequency\Projection\HashtagFrequencyView;

class HashtagFrequencyProjectionRendererTest extends RendererTestCase
{
    /** @var HashtagFrequencyProjectionRenderer */
    private $renderer;

    /** @var HashtagFrequencyProjection|ObjectProphecy */
    private $projection;

    /** @test */
    public function it_renders_list_of_keywords_with_count()
    {
        $this->projection
            ->get('screenName')
            ->willReturn([
                new HashtagFrequencyView('keyword1', 100),
                new HashtagFrequencyView('keyword2', 34),
            ]);

        $this->renderer->render('screenName', $this->output());

        $this->assertThatDisplayContains(
            'List of most frequently used #hashtags in latest 100 tweets for screen name "screenName":'
        );
        $this->assertThatDisplayContains('keyword1');
        $this->assertThatDisplayContains('keyword2');
        $this->assertThatDisplayContains('100');
        $this->assertThatDisplayContains('34');
    }

    /** @test */
    public function it_renders_empty_list_of_keywords()
    {
        $this->projection
            ->get('empty-screenName')
            ->willReturn([]);

        $this->renderer->render('empty-screenName', $this->output());

        $this->assertThatDisplayContains('There is no keywords for an screen name "empty-screenName"');
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        parent::setUp();

        $this->projection = $this->prophesize(HashtagFrequencyProjection::class);
        $this->renderer   = new HashtagFrequencyProjectionRenderer($this->projection->reveal());
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->projection = null;
        $this->renderer   = null;

        parent::tearDown();
    }
}
