<?php
/**
 * This code is licensed under the MIT License.
 *
 * Copyright (c) 2020 Alexey Kopytko <alexey@kopytko.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

declare(strict_types=1);

namespace Tests\ShipAndCoSDK;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ShipAndCoSDK\Client;
use ShipAndCoSDK\ClientBuilder;

/**
 * @covers \ShipAndCoSDK\ClientBuilder
 */
class ClientBuilderTest extends TestCase
{
    public function test_it_builds()
    {
        $builder = new ClientBuilder();
        $this->assertInstanceOf(Client::class, $builder->build());
    }

    public function test_middleware_normalizes_empty_code_object()
    {
        $middleware = $this->getMiddleware();

        $input = '{"debug_id":"err_test","code":{},"message":""}';
        $expected = '{"debug_id":"err_test","code":null,"message":""}';

        $response = new Response(400, [], $input);

        $handler = $middleware(function ($request, $options) use ($response) {
            return \GuzzleHttp\Promise\Create::promiseFor($response);
        });

        $result = $handler(null, [])->wait();

        $this->assertSame($expected, (string) $result->getBody());
    }

    public function test_middleware_preserves_valid_code_string()
    {
        $middleware = $this->getMiddleware();

        $input = '{"debug_id":"err_test","code":"VALIDATION_ERROR","message":"Error"}';

        $response = new Response(400, [], $input);

        $handler = $middleware(function ($request, $options) use ($response) {
            return \GuzzleHttp\Promise\Create::promiseFor($response);
        });

        $result = $handler(null, [])->wait();

        $this->assertSame($input, (string) $result->getBody());
    }

    public function test_middleware_handles_empty_object_with_whitespace()
    {
        $middleware = $this->getMiddleware();

        $input = '{"code": {  }}';
        $expected = '{"code":null}';

        $response = new Response(400, [], $input);

        $handler = $middleware(function ($request, $options) use ($response) {
            return \GuzzleHttp\Promise\Create::promiseFor($response);
        });

        $result = $handler(null, [])->wait();

        $this->assertSame($expected, (string) $result->getBody());
    }

    private function getMiddleware(): callable
    {
        $reflection = new ReflectionClass(ClientBuilder::class);
        $method = $reflection->getMethod('normalizeResponseMiddleware');
        $method->setAccessible(true);

        return $method->invoke(null);
    }
}
