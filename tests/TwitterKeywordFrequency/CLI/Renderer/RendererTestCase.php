<?php

declare (strict_types = 1);

namespace tests\TwitterKeywordFrequency\CLI\Renderer;

use Symfony\Component\Console\Output\StreamOutput;

abstract class RendererTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var resource */
    protected $stream;

    /** @var string */
    protected $display;

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->stream = fopen('php://memory', 'w', false);
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->stream  = null;
        $this->display = null;

        parent::tearDown();
    }

    protected function output()
    {
        return new StreamOutput($this->stream);
    }

    protected function assertThatDisplayContains($expectedString)
    {
        $this->assertContains($expectedString, $this->display());
    }

    private function display()
    {
        if (null !== $this->display) {
            return $this->display;
        }

        rewind($this->stream);
        $this->display = stream_get_contents($this->stream);

        return $this->display;
    }
}
