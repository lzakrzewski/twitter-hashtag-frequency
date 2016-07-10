<?php

declare (strict_types = 1);

namespace tests\TwitterHashtagFrequency\Infrastructure;

use TwitterHashtagFrequency\Infrastructure\OAuth;

class OAuthTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_be_built()
    {
        $oauth = OAuth::build(
            'customer-key',
            'customer-secret',
            'access-token',
            'access-token-secret',
            'http://endpoint?param1=value1&param2=value1'
        );

        $this->assertInstanceOf(OAuth::class, $oauth);

        $timestamp = time();

        $this->assertEquals('customer-key', $oauth->customerKey());
        $this->assertEquals($timestamp, $oauth->nonce());
        $this->assertEquals($timestamp, $oauth->timestamp());
        $this->assertEquals('access-token', $oauth->token());
        $this->assertNotEmpty($oauth->signature());
        $this->assertEquals('HMAC-SHA1', $oauth->signatureMethod());
        $this->assertEquals('1.0', $oauth->version());
    }

    /** @test */
    public function it_can_not_be_built_with_invalid_url()
    {
        $this->expectException(\InvalidArgumentException::class);

        OAuth::build(
            'customer-key',
            'customer-secret',
            'access-token',
            'access-token-secret',
            'http://invalid-uri'
        );
    }
}
