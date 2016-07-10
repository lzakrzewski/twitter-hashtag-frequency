<?php

declare (strict_types = 1);

namespace tests\fixtures;

use TwitterHashtagFrequency\HashtagProvider;
use TwitterHashtagFrequency\HashtagProviderFailed;

class FakeHashtagProvider implements HashtagProvider
{
    public function get(string $screenName) : array
    {
        if ($screenName == 'something-is-wrong') {
            throw new HashtagProviderFailed('Something is wrong.');
        }

        $result = $this->hashtags('keyword1', 1000);
        $result = array_merge($this->hashtags('keyword2', 603), $result);
        $result = array_merge($this->hashtags('keyword3', 24), $result);
        $result = array_merge($this->hashtags('keyword4', 10), $result);

        shuffle($result);

        return $result;
    }

    private function hashtags(string $hashtag, int $expectedCount) : array
    {
        $hashTags = [];

        for ($hashtagIdx = 1; $hashtagIdx <= $expectedCount; ++$hashtagIdx) {
            $hashTags[] = $hashtag;
        }

        return $hashTags;
    }
}
