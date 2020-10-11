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

use ShipAndCoSDK\Responses\AddressesResponse;
use ShipAndCoSDK\Responses\Types\Address\DatedWrapper;

/**
 * @covers \ShipAndCoSDK\Responses\AddressesResponse
 * @covers \ShipAndCoSDK\Responses\Types\Address\DatedWrapper
 */
class AddressesResponseTest extends TestCase
{
    public function commonResponsesProvider(): iterable
    {
        yield ['addresses.json', 1];
    }

    /**
     * @dataProvider commonResponsesProvider
     */
    public function test_successful_request(string $fixtureName, int $count)
    {
        $this->assertListResponse($fixtureName, $count, DatedWrapper::class, function (DatedWrapper $address) {
            $this->assertNotNull($address->id);
            $this->assertInstanceOf(\DateTimeInterface::class, $address->created_at);
            $this->assertInstanceOf(\DateTimeInterface::class, $address->updated_at);

            $this->assertNotNull($address->address);

            $this->assertNotNull($address->full_name);
            $this->assertNotNull($address->company);
            $this->assertNotNull($address->address1);
            $this->assertNotNull($address->address2);
            $this->assertNotNull($address->address3);
            $this->assertNotNull($address->city);
            $this->assertNotNull($address->province);
            $this->assertNotNull($address->zip);
            $this->assertNotNull($address->country);
            $this->assertNotNull($address->phone);
            $this->assertNotNull($address->email);
        });
    }

    /** @return AddressesResponse */
    protected function loadFixture(string $filename)
    {
        return $this->loadFixtureWithType($filename, AddressesResponse::class);
    }
}
