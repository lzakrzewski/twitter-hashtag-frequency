<?php

declare (strict_types = 1);

namespace TwitterKeywordFrequency\Application\Projection;

final class TwitterKeywordFrequencyView
{
    /** @var string */
    public $keyword;

    /** @var int */
    public $count;

    public function __construct(string $keyword, int $count)
    {
        $this->keyword = $keyword;
        $this->count   = $count;
    }
}
