<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency\Infrastructure;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use TwitterHashtagFrequency\Application\Projection\TwitterHashtagFrequencyProjection;

class GuzzleTwitterHashtagFrequencyProjection implements TwitterHashtagFrequencyProjection
{
    const OAUTH_CONSUMER_KEY     = 'gWH9q1Hzfn3ibNNRvM5tU7tfw';
    const OAUTH_NONCE            = 'c7b42ad4cbb3d21cbee0c312e73c731e';
    const OAUTH_SIGNATURE        = 'qbza%2BE0oFpeoDGz8nLfNBP%2FOmyg%3D';
    const OAUTH_SIGNATURE_METHOD = 'HMAC-SHA1';
    const OAUTH_TOKEN            = '751912533200662528-IJvPu0j4LThIKFvmkD2bjMKWDU05lfH';
    const OAUTH_VERSION          = '1.0';

    /** @var ClientInterface */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /** {@inheritdoc} */
    public function get(string $screenName) : array
    {
        $this->request($screenName);

        return [];
    }

    private function request(string $screenName) : ResponseInterface
    {
        $request = new Request(
            'GET',
            sprintf('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=%s&count=2', $screenName),
            [
                'Authorization' => $this->authorizationHeader(),
            ]
        );

        return $this->client->send($request);
    }

    private function authorizationHeader() : string
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

        return sprintf(
            str_replace(PHP_EOL, '', $pattern),
            self::OAUTH_CONSUMER_KEY,
            self::OAUTH_NONCE,
            self::OAUTH_SIGNATURE,
            self::OAUTH_SIGNATURE_METHOD,
            '1468106338',
            self::OAUTH_TOKEN,
            self::OAUTH_VERSION
        );
    }
}
