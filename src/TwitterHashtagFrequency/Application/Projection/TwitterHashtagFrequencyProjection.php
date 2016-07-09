<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency\Application\Projection;

interface TwitterHashtagFrequencyProjection
{
    /**
     * @param string $screenName
     *
     * @return TwitterHashtagFrequencyView[]
     */
    public function get(string $screenName) : array;
}
