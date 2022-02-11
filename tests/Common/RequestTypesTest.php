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

namespace Tests\ShipAndCoSDK\Common;

use CommonSDK\Concerns\PropertyRead;
use ShipAndCoSDK\Requests\Concerns\ShipmentFields;
use ShipAndCoSDK\Requests\Types\Address;
use ShipAndCoSDK\Requests\Types\Customs;
use ShipAndCoSDK\Requests\Types\Setup;
use ShipAndCoSDK\Requests\Types\Setup\Care;
use ShipAndCoSDK\Requests\Types\Setup\CashOnDelivery;

/**
 * @covers \ShipAndCoSDK\Requests\Types\Setup
 * @covers \ShipAndCoSDK\Responses\Types\Address\DatedWrapper
 * @covers \ShipAndCoSDK\Requests\Concerns\ShipmentFields
 */
class RequestTypesTest extends TestCase
{
    public function test_setup_has_default_properties()
    {
        $it = new Setup();
        $this->assertNotNull($it->care);
        $this->assertNotNull($it->cash_on_delivery);
    }

    public function test_setup_has_overriden_properties()
    {
        $care = new Care();
        $cash_on_delivery = new CashOnDelivery();

        $it = new Setup($care, $cash_on_delivery);
        $this->assertSame($care, $it->care);
        $this->assertSame($cash_on_delivery, $it->cash_on_delivery);
    }

    public function test_shipment_fields_trait_has_sane_defaults()
    {
        $instance = $this->getShipmentFieldsExample(null);

        foreach ([
            'to_address' => Address::class,
            'from_address' => Address::class,
            'customs' => Customs::class,
            'setup' => Setup::class,
        ] as $field => $type) {
            $this->assertNotNull($instance->{$field});
            $this->assertInstanceOf($type, $instance->{$field});
        }
    }

    public function test_shipment_fields_trait_has_custom_fields()
    {
        $args = [
            'to_address'   => new Address(),
            'from_address' => new Address(),
            'customs'      => new Customs(),
            'setup'        => new Setup(),
        ];

        $instance = $this->getShipmentFieldsExample(...array_values($args));

        foreach ($args as $field => $type) {
            $this->assertNotNull($instance->{$field});
            $this->assertSame($type, $instance->{$field});
        }
    }

    private function getShipmentFieldsExample(...$args)
    {
        return new class(...$args) {
            use ShipmentFields;
            use PropertyRead;
        };
    }
}
