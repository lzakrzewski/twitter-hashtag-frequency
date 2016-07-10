<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency\Projection;

final class HashtagFrequencyView
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
