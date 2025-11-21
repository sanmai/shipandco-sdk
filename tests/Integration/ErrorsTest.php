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

namespace Tests\ShipAndCoSDK\Integration;

use ShipAndCoSDK\Requests\RatesRequest;

if (false) {
    include 'examples/020_ResponseErrorHandling.php';
}

/**
 * @covers \ShipAndCoSDK\Client
 *
 * @group integration
 */
final class ErrorsTest extends TestCase
{
    public function test_it_handles_auth_error()
    {
        /** @var \ShipAndCoSDK\Responses\Bad\ErrorResponse $response */
        $response = $this->getClient()->sendRatesRequest(new RatesRequest());

        $this->assertCount(0, $response);

        $this->assertTrue($response->hasErrors());

        foreach ($response->getMessages() as $message) {
            $this->assertNotEmpty($message->getErrorCode());
            $this->assertNotEmpty($message->getMessage());
        }

        $this->assertNotEmpty($response->message);
        $this->assertIsIterable($response->details);

        foreach ($response->details as $detail) {
            $this->assertNotEmpty($detail->code);
            $this->assertNotEmpty($detail->message);
        }
    }
}
