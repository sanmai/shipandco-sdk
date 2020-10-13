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

use ShipAndCoSDK\Responses\RatesResponse;
use ShipAndCoSDK\Responses\Types\Rate;

/**
 * @covers \ShipAndCoSDK\Responses\RatesResponse
 */
class RatesResponseTest extends TestCase
{
    public function commonResponsesProvider(): iterable
    {
        yield ['rates.json', 3];

        yield ['rates2.json', 5];
    }

    /**
     * @dataProvider commonResponsesProvider
     */
    public function test_successful_request(string $fixtureName, int $count)
    {
        $this->assertListResponse($fixtureName, $count, Rate::class, function (Rate $rate) {
            $this->assertGreaterThan(0, $rate->price);

            foreach ($rate->surcharges as $surcharge) {
                $this->assertGreaterThan(0, $surcharge->price);
            }
        });
    }

    /** @return RatesResponse */
    protected function loadFixture(string $filename)
    {
        return $this->loadFixtureWithType($filename, RatesResponse::class);
    }
}
