<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency\Infrastructure;

final class OAuth
{
    const OAUTH_SIGNATURE_METHOD = 'HMAC-SHA1';
    const OAUTH_VERSION          = '1.0';

    /** @var string */
    private $customerKey;

    /** @var string */
    private $customerSecret;

    /** @var string */
    private $accessToken;

    /** @var string */
    private $accessTokenSecret;

    /** @var string */
    private $uri;

    /** @var string */
    private $nonce;

    /** @var string */
    private $timestamp;

    /** @var string */
    private $signature;

    private function __construct(
        string $customerKey,
        string $customerSecret,
        string $accessToken,
        string $accessTokenSecret,
        string $uri
    ) {
        $this->customerKey       = $customerKey;
        $this->customerSecret    = $customerSecret;
        $this->accessToken       = $accessToken;
        $this->accessTokenSecret = $accessTokenSecret;
        $this->uri               = $uri;

        $timestamp = (string) time();

        $this->nonce     = $timestamp;
        $this->timestamp = $timestamp;

        $this->signature = $this->calculateSignature();
    }

    public static function build(
        string $customerKey,
        string $customerSecret,
        string $accessToken,
        string $accessTokenSecret,
        string $uri
    ) : self {
        return new self($customerKey, $customerSecret, $accessToken, $accessTokenSecret, $uri);
    }

    public function customerKey() : string
    {
        return $this->customerKey;
    }

    public function nonce() : string
    {
        return $this->nonce;
    }

    public function signature() : string
    {
        return $this->signature;
    }

    public function signatureMethod()
    {
        return self::OAUTH_SIGNATURE_METHOD;
    }

    public function timestamp() : string
    {
        return $this->timestamp;
    }

    public function token() : string
    {
        return $this->accessToken;
    }

    public function version() : string
    {
        return self::OAUTH_VERSION;
    }

    private function calculateSignature() : string
    {
        $baseString = $this->baseString();

        return $this->oauthSignature($baseString);
    }

    private function uriParts() : array
    {
        $uriParts = explode('?', $this->uri);

        if (2 !== count($uriParts)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Uri is invalid. It should be consistent with "http://encpoint?param1=value1&param2=value2" pattern. "%s" given',
                    $this->uri
                )
            );
        }

        return $uriParts;
    }

    private function oauthSignature(string $baseString) : string
    {
        $compositeKey   = rawurlencode($this->customerSecret).'&'.rawurlencode($this->accessTokenSecret);
        $oauthSignature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));

        return rawurlencode($oauthSignature);
    }

    private function baseString() : string
    {
        $uriParts = $this->uriParts();

        $oauthParameters = [
            'oauth_consumer_key'     => $this->customerKey,
            'oauth_nonce'            => $this->nonce,
            'oauth_signature_method' => self::OAUTH_SIGNATURE_METHOD,
            'oauth_token'            => $this->accessToken,
            'oauth_timestamp'        => $this->timestamp,
            'oauth_version'          => self::OAUTH_VERSION,
        ];

        parse_str($uriParts[1], $uriParams);

        return $this->buildBaseString(
            $uriParts[0],
            'GET',
            array_merge($uriParams, $oauthParameters)
        );
    }

    private function buildBaseString(string $baseURI, string $method, array $params) : string
    {
        $result = [];
        ksort($params);

        foreach ($params as $key => $value) {
            $result[] = rawurlencode($key).'='.rawurlencode($value);
        }

        return $method.'&'.rawurlencode($baseURI).'&'.rawurlencode(implode('&', $result));
    }
}
