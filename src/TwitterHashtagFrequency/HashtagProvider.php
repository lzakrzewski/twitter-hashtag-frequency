<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency;

interface HashtagProvider
{
    /**
     * @param string $screenName
     *
     * @throws HashtagProviderFailed
     *
     * @return array
     */
    public function get(string $screenName) : array;
}
