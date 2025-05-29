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

namespace ShipAndCoSDK\Requests\Types;

use CommonSDK\Concerns\ObjectPropertyRead;
use CommonSDK\Concerns\PropertyWrite;
use CommonSDK\Contracts\ReadableRequestProperty;
use DateTimeInterface;
use JMS\Serializer\Annotation as JMS;
use ShipAndCoSDK\Common\Setup as CommonSetup;
use ShipAndCoSDK\Requests\Types\Setup\Care;
use ShipAndCoSDK\Requests\Types\Setup\CashOnDelivery;

/**
 * @property-write string $carrier
 * @property-write string $carrier_id
 * @property-write string $service
 * @property-write string $currency
 * @property-write DateTimeInterface $shipment_date
 * @property-write DateTimeInterface $date
 * @property-write string $time
 * @property-write float|int $insurance
 * @property-write string $ref_number
 * @property-write string $delivery_note
 * @property-write float|int $discount
 * @property-write bool $signature
 * @property-write string $cool_options
 * @property-read Care $care
 * @property-write int $pack_size
 * @property-write int $pack_amount
 * @property-read CashOnDelivery $cash_on_delivery
 * @property-write bool $return_label
 * @property-write int $print_start_location
 * @property-write float $shipping_fee
 * @property-write bool $security_service
 * @property-write string $consignee_tax_id
 * @property-write bool $test
 */
final class Setup extends CommonSetup implements ReadableRequestProperty
{
    use PropertyWrite;
    use ObjectPropertyRead;

    /**
     * @JMS\Type("ShipAndCoSDK\Requests\Types\Setup\Care")
     *
     * @var Care
     */
    private $care;

    /**
     * @JMS\Type("ShipAndCoSDK\Requests\Types\Setup\CashOnDelivery")
     *
     * @var CashOnDelivery
     */
    private $cash_on_delivery;

    /**
     * @phan-suppress PhanAccessReadOnlyMagicProperty
     */
    public function __construct(?Care $care = null, ?CashOnDelivery $cash_on_delivery = null)
    {
        $this->care = $care ?? new Care();
        $this->cash_on_delivery = $cash_on_delivery ?? new CashOnDelivery();
    }
}
