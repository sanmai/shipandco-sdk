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

use ShipAndCoSDK\Responses\Types\Product;

/**
 * @covers \ShipAndCoSDK\Responses\Types\Product
 */
class ProductTest extends TestCase
{
    public static function productProvider(): iterable
    {
        yield 'integer price' => ['{"price": 4850}', [
            'price' => 4850,
        ]];

        yield 'float price with identifiers' => ['{
            "price": 24.5,
            "hs_description": "T-shirts, knitted, of cotton",
            "item_id": "variant_89431",
            "sku": "TSHIRT-NVY-M",
            "mpn": "ACME-TS-1042",
            "barcode": "4901234567894"
        }', [
            'price'          => 24.5,
            'hs_description' => 'T-shirts, knitted, of cotton',
            'item_id'        => 'variant_89431',
            'sku'            => 'TSHIRT-NVY-M',
            'mpn'            => 'ACME-TS-1042',
            'barcode'        => '4901234567894',
        ]];
    }

    /**
     * @dataProvider productProvider
     */
    public function test_product(string $json, array $expected)
    {
        $product = $this->getSerializer()->deserialize($json, Product::class);

        foreach ($expected as $property => $value) {
            $this->assertSame($value, $product->{$property});
        }
    }

    /** @return Product */
    protected function loadFixture(string $filename)
    {
        return $this->loadFixtureWithType($filename, Product::class);
    }
}
