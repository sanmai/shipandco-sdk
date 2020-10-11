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

use CommonSDK\Contracts\ItemList;
use CommonSDK\Contracts\Response;
use JSONSerializer\Serializer;
use Tests\ShipAndCoSDK\Fixtures\FixtureLoader;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    private $serializer;

    protected function setUp(): void
    {
        // Pretty-print serialized requests
        $this->serializer = Serializer::withJSONOptions(JSON_PRESERVE_ZERO_FRACTION | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    protected function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    abstract protected function loadFixture(string $filename);

    protected function loadFixtureWithType(string $filename, string $type)
    {
        return $this->getSerializer()->deserialize(FixtureLoader::loadResponse($filename), $type);
    }

    /**
     * @param ItemList|Response|string $response actual response or fixture file name
     */
    protected function assertListResponse($response, int $count, string $itemType, ?callable $itemCallback = null)
    {
        if (\is_string($response)) {
            $response = $this->loadFixture($response);
        }

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ItemList::class, $response);

        $this->assertFalse($response->hasErrors());

        $this->assertCount($count, $response);

        foreach ($response as $item) {
            $this->assertInstanceOf($itemType, $item);

            if ($itemCallback !== null) {
                $itemCallback($item);
            }
        }
    }
}
