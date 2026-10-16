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

use ShipAndCoSDK\Responses\RegisterCarrierResponse;
use DateTimeInterface;

use function json_decode;
use function in_array;
use function var_export;

/**
 * @covers \ShipAndCoSDK\Responses\RegisterCarrierResponse
 * @covers \ShipAndCoSDK\Responses\Types\Carrier
 * @covers \ShipAndCoSDK\Responses\Types\Carrier\Settings
 * @covers \ShipAndCoSDK\Responses\Types\Carrier\SettingsPrint
 * @covers \ShipAndCoSDK\Responses\Types\Carrier\SettingsLabel
 */
class RegisterCarrierResponseTest extends TestCase
{
    public function commonResponsesProvider(): iterable
    {
        yield ['register_carrier_dhl.json', [
            'id'         => 'carrier_123abc',
            'created_at' => '2025-03-10T06:49:21.730000+0000',
            'updated_at' => '2025-03-10T06:49:21.730000+0000',
            'type'       => 'dhl',
            'state'      => 'active',
            'credentials' => [
                'account_number' => '****6789',
                'site_id'        => '****123',
            ],
            'settings' => [
                'print' => [
                    'size' => 'PDF_A4',
                ],
                'label' => [
                    'hide_account' => false,
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

        $this->assertNotEmpty($response->id);
        $this->assertSame('dhl', $response->type);
        $this->assertSame('active', $response->state);
        $this->assertInstanceOf(DateTimeInterface::class, $response->created_at);
        $this->assertInstanceOf(DateTimeInterface::class, $response->updated_at);

        $responseArray = json_decode($this->getSerializer()->serialize($response), true);

        if (in_array('--debug', $_SERVER['argv']) && $responseArray !== $expected) {
            echo "\n";
            var_export([$fixtureName, $responseArray]);
            echo "\n";
        }

        $this->assertSame($expected, $responseArray);
    }

    /** @return RegisterCarrierResponse */
    protected function loadFixture(string $filename)
    {
        return $this->loadFixtureWithType($filename, RegisterCarrierResponse::class);
    }
}
