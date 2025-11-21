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

use CommonSDK\Tests\Common\ClientTestCase;
use GuzzleHttp\ClientInterface;
use ShipAndCoSDK\Client;
use ShipAndCoSDK\ClientBuilder;
use Tests\ShipAndCoSDK\Fixtures\FixtureLoader;

/**
 * @covers \ShipAndCoSDK\Client
 */
class ClientTest extends ClientTestCase
{
    /** @return Client */
    public function newClient(?ClientInterface $http = null)
    {
        $builder = new ClientBuilder();
        $builder->setGuzzleClient($http ?? $this->getHttpClient());

        return $builder->build();
    }

    public function errorResponsesProvider(): iterable
    {
        yield 'error_403.json' => ['error_403.json', 403, [
            ['AUTH', 'Wrong token!'],
        ]];

        yield 'error_400.json' => ['error_400.json', 400, [
            ['VALIDATION_ERROR', 'リクエストフォームに問題があります。構造に誤りがあるか、スキーマに反しています。'],
            ['INSUFFICIENT', 'この項目の内容が少なすぎます (最小: 1)'],
            ['REQUIRED', 'この項目は必須です'],
            ['REQUIRED', 'この項目は必須です'],
        ]];

        // Ship&co sometimes returns JSON with text/html content-type
        yield 'error_400_shipment.json with text/html' => ['error_400_shipment.json', 400, [
            ['SHIPMENT_FAILED', 'Shipment creation failed'],
        ], 'text/html; charset=utf-8'];
    }

    public function loadFixture($filename): string
    {
        return FixtureLoader::loadResponse($filename);
    }
}
