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

use ShipAndCoSDK\Responses\ShipmentResponse;

use function json_decode;
use function in_array;
use function var_export;

/**
 * @covers \ShipAndCoSDK\Responses\ShipmentResponse
 */
class ShipmentResponseTest extends TestCase
{
    public function commonResponsesProvider(): iterable
    {
        yield ['shipment_response.json', [
            'id'         => 'API-QQQQQQQ',
            'state'      => 'active',
            'test'       => true,
            'created_at' => '2020-10-10T00:00:00.000000+0000',
            'to_address' => [
                'address1'  => '京都市中京区八百屋町117',
                'city'      => '京都府',
                'country'   => 'JP',
                'full_name' => 'TEST TARO',
                'phone'     => '1111111111',
                'zip'       => '604-8072',
            ],
            'from_address' => [
                'address1'  => 'OSAKAFU',
                'city'      => 'IBARAKI SHI',
                'country'   => 'JP',
                'full_name' => 'テスト',
                'phone'     => '08012341234',
                'province'  => 'OSAKA',
                'zip'       => '1234567',
            ],
            'products' => [
                [
                    'name'           => 'Blue Basketball',
                    'quantity'       => 2,
                    'price'          => 4850,
                    'hs_code'        => '',
                    'origin_country' => 'JP',
                ],

                [
                    'name'           => 'Orange Basketball',
                    'quantity'       => 1,
                    'price'          => 7850,
                    'hs_code'        => '',
                    'origin_country' => 'JP',
                ],
            ],
            'parcels' => [
            ],
            'setup' => [
                'currency'             => 'JPY',
                'date'                 => '2020-10-16',
                'time'                 => '16-18',
                'insurance'            => 0.0,
                'ref_number'           => '',
                'delivery_note'        => '',
                'discount'             => 0.0,
                'pack_size'            => '0',
                'pack_amount'          => 3,
                'print_start_location' => 1,
                'test'                 => true,
                'care'                 => [
                    'fragile'        => false,
                    'side_up'        => false,
                    'valuable_goods' => false,
                ],
            ],
            'delivery' => [
                'carrier'          => 'sagawa',
                'method'           => 'sagawa_regular',
                'tracking_numbers' => [
                    '514699888883',
                ],
                'label'    => 'https://storage.googleapis.com/live-shipandco/labels/202010/example.pdf',
                'invoice'  => 'JVBERg==',
                'warnings' => [],
            ],
        ]];

        yield ['shipment_japanpost.json', [
            'id'         => 'API-O8APFNW9S8',
            'state'      => 'active',
            'created_at' => '2019-01-07T14:15:01.151000+0000',
            'to_address' => [
                'address1'  => 'Rua Maria Matos, 32',
                'address2'  => '',
                'city'      => 'CHARNECA DA CAPARICA',
                'company'   => 'ACME',
                'country'   => 'PT',
                'email'     => 'john@example.net',
                'full_name' => 'John Doe',
                'phone'     => '0901231234',
                'province'  => 'SETUBAL',
                'zip'       => '2820-344',
            ],
            'from_address' => [
                'address1'  => 'OSAKAFU',
                'address2'  => 'OTECHO',
                'city'      => 'IBARAKI SHI',
                'company'   => 'World Company',
                'country'   => 'JP',
                'email'     => 'ytaro@worldcompany.com',
                'full_name' => 'Yamada Taro',
                'phone'     => '08012341234',
                'province'  => 'OSAKA',
                'zip'       => '5670883',
            ],
            'products' => [
                [
                    'name'           => 'Basket ball',
                    'quantity'       => 2,
                    'price'          => 4850,
                    'hs_code'        => 'HS9988',
                    'origin_country' => 'JP',
                ],
            ],
            'parcels' => [
                [
                    'amount' => 1,
                    'depth'  => 10,
                    'height' => 10,
                    'width'  => 10,
                    'weight' => 200.0,
                ],
            ],
            'customs' => [
                'duty_paid'    => false,
                'content_type' => 'MERCHANDISE',
            ],
            'setup' => [
                'currency'      => 'JPY',
                'insurance'     => 0.0,
                'ref_number'    => '',
                'delivery_note' => '',
                'discount'      => 0.0,
                'signature'     => false,
                'return_label'  => false,
                'test'          => true,
            ],
            'delivery' => [
                'carrier'          => 'japanpost',
                'method'           => 'japanpost_ems',
                'tracking_numbers' => [
                    'EN027977320JP',
                ],
                'label'    => 'https://storage.googleapis.com/dev-shipandco/labels/201901/example.pdf',
                'warnings' => [
                ],
            ],
        ]];

        yield ['shipment_sagawa.json', [
            'id'         => 'API-QWMHHRLQS8',
            'state'      => 'active',
            'test'       => true,
            'created_at' => '2019-08-31T07:14:20.209000+0000',
            'to_address' => [
                'address1'  => '京都市中京区八百屋町117',
                'address2'  => '',
                'city'      => '京都府',
                'company'   => '',
                'country'   => 'JP',
                'email'     => '',
                'full_name' => 'TEST TARO',
                'phone'     => '1111111111',
                'province'  => '',
                'zip'       => '604-8072',
            ],
            'from_address' => [
                'address1'  => 'OSAKAFU',
                'address2'  => '',
                'city'      => 'IBARAKI SHI',
                'company'   => '',
                'country'   => 'JP',
                'email'     => '',
                'full_name' => 'テスト',
                'phone'     => '08012341234',
                'province'  => 'OSAKA',
                'zip'       => '1234567',
            ],
            'products' => [
                [
                    'name'           => 'Basket ball',
                    'quantity'       => 2,
                    'price'          => 4850,
                    'hs_code'        => '',
                    'origin_country' => 'JP',
                ],
                [
                    'name'           => 'Basket ball2',
                    'quantity'       => 2,
                    'price'          => 4850,
                    'hs_code'        => '',
                    'origin_country' => 'JP',
                ],
                [
                    'name'           => 'Basket ball3',
                    'quantity'       => 2,
                    'price'          => 4850,
                    'hs_code'        => '',
                    'origin_country' => 'JP',
                ],
                [
                    'name'           => 'Basket ball4',
                    'quantity'       => 2,
                    'price'          => 4850,
                    'hs_code'        => '',
                    'origin_country' => 'JP',
                ],
                [
                    'name'           => 'Basket ball5',
                    'quantity'       => 2,
                    'price'          => 4850,
                    'hs_code'        => '',
                    'origin_country' => 'JP',
                ],
            ],
            'parcels' => [
            ],
            'setup' => [
                'currency'      => 'JPY',
                'date'          => '2020-07-28',
                'time'          => '16-18',
                'insurance'     => 0.0,
                'ref_number'    => '',
                'delivery_note' => '',
                'discount'      => 0.0,
                'pack_size'     => '0',
                'pack_amount'   => 3,
                'test'          => true,
                'care'          => [
                    'fragile'        => false,
                    'side_up'        => false,
                    'valuable_goods' => false,
                ],
            ],
            'delivery' => [
                'carrier'          => 'sagawa',
                'method'           => 'sagawa_regular',
                'tracking_numbers' => [
                    '514699854874',
                ],
                'label'    => 'https://storage.googleapis.com/dev-shipandco/labels/201908/example.pdf',
                'invoice'  => 'JVBERg==',
                'warnings' => [
                    'DUMMY_WARNING',
                ],
            ],
        ]];

        yield ['shipment_fedex.json', [
            'id'       => 'API-QWMHHRLQS8',
            'products' => [],
            'parcels'  => [],
            'delivery' => [
                'tracking_numbers' => [],
                'warnings'         => [
                    [
                        'message' => 'etd_not_available',
                        'type'    => 'label',
                    ],
                ],
            ],
        ]];
    }

    /**
     * @dataProvider commonResponsesProvider
     */
    public function test_successful_request(string $fixtureName, array $expected)
    {
        $response = $this->loadFixture($fixtureName);

        $this->assertStringStartsWith('API-', $response->id);

        $responseArray = json_decode($this->getSerializer()->serialize($response), true);

        if (in_array('--debug', $_SERVER['argv']) && $responseArray !== $expected) {
            echo "\n";
            var_export([$fixtureName, $responseArray]);
            echo "\n";
        }

        $this->assertSame($expected, $responseArray);
    }

    /** @return ShipmentResponse */
    protected function loadFixture(string $filename)
    {
        return $this->loadFixtureWithType($filename, ShipmentResponse::class);
    }
}
