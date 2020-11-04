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

namespace Tests\ShipAndCoSDK\Deserialization;

use CommonSDK\Contracts\HasErrorCode;
use CommonSDK\Contracts\Response;
use function Pipeline\zip;
use ShipAndCoSDK\Responses\Bad\ErrorResponse;

/**
 * @covers \ShipAndCoSDK\Responses\Bad\ErrorResponse
 * @covers \ShipAndCoSDK\Responses\Bad\ErrorResponse\Detail
 */
class ErrorResponsesTest extends TestCase
{
    public function errorResponsesProvider()
    {
        yield 'error_400.json' => ['error_400.json', [
            ['VALIDATION_ERROR', 'リクエストフォームに問題があります。構造に誤りがあるか、スキーマに反しています。'],
            ['INSUFFICIENT', 'この項目の内容が少なすぎます (最小: 1)'],
            ['REQUIRED', 'この項目は必須です'],
            ['REQUIRED', 'この項目は必須です'],
        ]];

        yield 'error_403.json' => ['error_403.json', [
            ['AUTH', 'Wrong token!'],
        ]];

        yield 'error_403_w_code.json' => ['error_403_w_code.json', [
            ['AUTH2', 'Something isn\'t right'],
        ]];

        yield 'error_400_SHIPMENT_FAILED.json' => ['error_400_SHIPMENT_FAILED.json', [
            ['SHIPMENT_FAILED', 'ラベル作成時に接続エラーが発生しました。少し時間をおいてから、もう一度試してください。'],
            ['INVALID', 'SAGAWA does not have packages available. Only DHL, FEDEX can have packages.'],
        ]];

        yield 'error_400_SAGAWA.json' => ['error_400_SAGAWA.json', [
            ['SAGAWA_E1-0029', '配達指定日が過去日付です'],
        ]];

        yield 'error_400_ONE_OF_REQUIRED.json' => ['error_400_ONE_OF_REQUIRED.json', [
            ['VALIDATION_ERROR', 'リクエストフォームに問題があります。構造に誤りがあるか、スキーマに反しています。'],
            ['REQUIRED', 'この項目は必須です'],
            ['REQUIRED', 'この項目は必須です'],
            ['ONE_OF_REQUIRED', '必須項目のうち、未入力もしくは無効なものがあります。'],
            ['ONE_OF_REQUIRED', '必須項目のうち、未入力もしくは無効なものがあります。'],
        ]];

        yield 'error_500_no_message.json' => ['error_500_no_message.json', [
            ['BAD_REQUEST', 'Server made a boo'],
        ]];
    }

    /**
     * @dataProvider errorResponsesProvider
     */
    public function test_it_can_be_read(string $fixtureFileName, array $errors)
    {
        $response = $this->loadFixture($fixtureFileName);
        /** @var $response Response */
        $this->assertInstanceOf(Response::class, $response);

        $this->assertCount(0, $response);
        $this->assertTrue($response->hasErrors());

        $this->assertCount(\count($errors), $response->getMessages());

        $this->assertCount(\count($errors), zip($errors, $response->getMessages())
            ->unpack(function (array $expected, HasErrorCode $message) {
                $this->assertSame($expected[0], $message->getErrorCode());
                $this->assertSame($expected[1], $message->getMessage());
            })
        );
    }

    public function test_it_returns_correct_message()
    {
        $error = $this->deserializeResponse('{"message":"foo", "description":"bar", "debug_id":"baz"}');

        $this->assertSame('foo', $error->getMessage());

        $error = $this->deserializeResponse('{"description":"bar", "debug_id":"baz"}');

        $this->assertSame('bar', $error->getMessage());

        $error = $this->deserializeResponse('{"debug_id":"baz"}');

        $this->assertSame('baz', $error->getMessage());
    }

    protected function deserializeResponse(string $json): ErrorResponse
    {
        return $this->getSerializer()->deserialize($json, ErrorResponse::class);
    }

    /** @return ErrorResponse */
    protected function loadFixture(string $filename): ErrorResponse
    {
        return $this->loadFixtureWithType($filename, ErrorResponse::class);
    }
}
