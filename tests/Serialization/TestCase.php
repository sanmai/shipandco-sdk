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

namespace Tests\ShipAndCoSDK\Serialization;

use CommonSDK\Contracts\Request;
use Tests\ShipAndCoSDK\Deserialization\TestCase as DeserializationTestCase;
use Tests\ShipAndCoSDK\Fixtures\FixtureLoader;

abstract class TestCase extends DeserializationTestCase
{
    protected function assertSameAsJSON(string $json, $request)
    {
        $serializedString = $this->getSerializer()->serialize($request, Request::SERIALIZATION_JSON);

        $this->assertSame($json, $serializedString);
    }

    protected function assertSameAsFixture(string $filename, $input)
    {
        $actualJson = $this->getSerializer()->serialize($input, Request::SERIALIZATION_JSON);

        if (isset($_SERVER['GOLDEN'])) {
            $this->assertTrue(FixtureLoader::saveRequest($filename, $actualJson), "Unable to save a golden fixture to '{$filename}'");
            $this->markTestIncomplete("Updated the golden fixture in '{$filename}'");
        }

        $this->assertSame(FixtureLoader::loadRequest($filename), $actualJson);
    }

    /**
     * @return string
     */
    protected function loadFixture(string $filename)
    {
        return FixtureLoader::loadRequest($filename);
    }
}
