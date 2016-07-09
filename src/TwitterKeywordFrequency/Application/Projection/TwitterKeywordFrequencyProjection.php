<?php

declare (strict_types = 1);

namespace TwitterKeywordFrequency\Application\Projection;

interface TwitterKeywordFrequencyProjection
{
    /**
     * @param string $account
     *
     * @return TwitterKeywordFrequencyView[]
     */
    public function get(string $account) : array;
}
