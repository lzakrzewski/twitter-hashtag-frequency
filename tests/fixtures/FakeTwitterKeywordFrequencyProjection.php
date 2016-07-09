<?php

declare (strict_types = 1);

namespace tests\fixtures;

use TwitterKeywordFrequency\Application\Projection\TwitterAPIConnectionFailed;
use TwitterKeywordFrequency\Application\Projection\TwitterKeywordFrequencyProjection;
use TwitterKeywordFrequency\Application\Projection\TwitterKeywordFrequencyView;

final class FakeTwitterKeywordFrequencyProjection implements TwitterKeywordFrequencyProjection
{
    /** {@inheritdoc} */
    public function get(string $account) : array
    {
        if ($account != 'test-account') {
            throw new TwitterAPIConnectionFailed('Something is wrong.');
        }

        return [
            new TwitterKeywordFrequencyView('keyword1', 1000),
            new TwitterKeywordFrequencyView('keyword2', 603),
            new TwitterKeywordFrequencyView('keyword3', 24),
            new TwitterKeywordFrequencyView('keyword4', 10),
        ];
    }
}
