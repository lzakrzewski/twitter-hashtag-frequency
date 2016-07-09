<?php

declare (strict_types = 1);

namespace tests\fixtures;

use TwitterHashtagFrequency\Application\Projection\TwitterAPIConnectionFailed;
use TwitterHashtagFrequency\Application\Projection\TwitterHashtagFrequencyProjection;
use TwitterHashtagFrequency\Application\Projection\TwitterHashtagFrequencyView;

final class FakeTwitterHashtagFrequencyProjection implements TwitterHashtagFrequencyProjection
{
    /** {@inheritdoc} */
    public function get(string $screenName) : array
    {
        if ($screenName != 'test-account') {
            throw new TwitterAPIConnectionFailed('Something is wrong.');
        }

        return [
            new TwitterHashtagFrequencyView('keyword1', 1000),
            new TwitterHashtagFrequencyView('keyword2', 603),
            new TwitterHashtagFrequencyView('keyword3', 24),
            new TwitterHashtagFrequencyView('keyword4', 10),
        ];
    }
}
