<?php

namespace Framework\Tests;

use Framework\HttpClient\HttpClient;
use Framework\HttpClient\Wrapper\CurlWrapper;
use PHPUnit\Framework\TestCase;

// todo: testat cu un raspuns de 1 gb
class HttpClientTest extends TestCase
{
    public function test_request()
    {
        $curl = $this->createMock(CurlWrapper::class);
        $ch = 'fake_handle';

        $curl->method('init')->willReturn($ch);
        $curl->method('exec')->willReturn("return body");
        $curl->method('getinfo')->willReturnMap([
            [$ch, CURLINFO_HTTP_CODE, 200]
        ]);

        $client = new HttpClient($curl);
        $response = $client->request('method', 'url', 'request body', []);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('return body', (string) $response->getBody());

        // verifica raspunsul
        
    }

    // public function test_sendRequest()
    // {
    //     $request = new Request('method', 'url', 'body', []);

    //     $client = new HttpClient();

    //     $response = $client->sendRequest($request);

    //     // verifica raspunsul
        
    // }
}