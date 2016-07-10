<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency\Infrastructure;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use TwitterHashtagFrequency\HashtagProvider;
use TwitterHashtagFrequency\HashtagProviderFailed;

class GuzzleHashtagProvider implements HashtagProvider
{
    const API_ENDPOINT = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    const LIMIT        = 100;

    /** @var ClientInterface */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /** {@inheritdoc} */
    public function get(string $screenName) : array
    {
        try {
            $response = $this->request($screenName);
        } catch (RequestException $e) {
            throw new HashtagProviderFailed($e->getMessage());
        }

        return $this->hashTagsFromResponse($response);
    }

    private function request(string $screenName) : ResponseInterface
    {
        $parameters = ['count' => self::LIMIT, 'screen_name' => $screenName];

        $request = new Request(
            'GET',
            $this->uri($parameters),
            [
                'Authorization' => $this->authorizationHeader($parameters),
            ]
        );

        return $this->client->send($request);
    }

    private function authorizationHeader(array $parameters) : string
    {
        $pattern = <<<STR
OAuth oauth_consumer_key="%s", 
oauth_nonce="%s", 
oauth_signature="%s", 
oauth_signature_method="%s", 
oauth_timestamp="%s", 
oauth_token="%s", 
oauth_version="%s"
STR;

        $oauth = OAuth::build(
            \ApplicationSettings::CUSTOMER_KEY,
            \ApplicationSettings::CUSTOMER_SECRET,
            \ApplicationSettings::ACCESS_TOKEN,
            \ApplicationSettings::ACCESS_TOKEN_SECRET,
            $this->uri($parameters)
        );

        return sprintf(
            str_replace(PHP_EOL, '', $pattern),
            $oauth->customerKey(),
            $oauth->nonce(),
            $oauth->signature(),
            $oauth->signatureMethod(),
            $oauth->timestamp(),
            $oauth->token(),
            $oauth->version()
        );
    }

    private function hashTagsFromResponse(ResponseInterface $response) : array
    {
        $contents = json_decode($response->getBody()->getContents(), true);

        $tweetsWithHashTags = array_filter($contents, function (array $tweet) {
            if (isset($tweet['entities']) && isset($tweet['entities']['hashtags'])) {
                $hashTagsInfo = $tweet['entities']['hashtags'];

                return !empty($hashTagsInfo);
            }
        });

        if (empty($tweetsWithHashTags)) {
            return [];
        }

        $hashTags = [];

        foreach ($tweetsWithHashTags as $tweet) {
            foreach ($tweet['entities']['hashtags'] as $hashtagInfo) {
                $hashTags[] = $hashtagInfo['text'];
            }
        }

        return $hashTags;
    }

    private function uri(array $parameters) : string
    {
        return sprintf('%s?%s', self::API_ENDPOINT, http_build_query($parameters));
    }
}
