<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency\Projection;

use TwitterHashtagFrequency\HashtagProvider;

class HashtagFrequencyProjection
{
    /** @var HashtagProvider */
    private $provider;

    public function __construct(HashtagProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param string $screenName
     *
     * @return HashtagFrequencyView[]
     */
    public function get(string $screenName) : array
    {
        $hashtags       = $this->provider->get($screenName);
        $uniqueHashtags = array_unique($hashtags);

        $views = $this->hashtagFrequencyViews($hashtags, $uniqueHashtags);

        return $this->sortedViews($views);
    }

    private function count(string $uniqueHashtag, array $hashtags) : int
    {
        $matching = array_filter(
            $hashtags,
            function (string $hashtag) use ($uniqueHashtag) {
                return $hashtag == $uniqueHashtag;
            }
        );

        return count($matching);
    }

    private function hashtagFrequencyViews(array $hashtags, array $uniqueHashtags) : array
    {
        return array_map(
            function (string $uniqueHashtag) use ($hashtags) {
                return new HashtagFrequencyView(
                    $uniqueHashtag,
                    $this->count($uniqueHashtag, $hashtags)
                );
            },
            $uniqueHashtags
        );
    }

    private function sortedViews(array $views) : array
    {
        usort($views, function (HashtagFrequencyView $first, HashtagFrequencyView $second) {
            return $first->count < $second->count;
        });

        return $views;
    }
}
