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

namespace ShipAndCoSDK\Responses\Types;

use CommonSDK\Concerns\PropertyRead;
use CommonSDK\Contracts\Property;
use DateTimeInterface;
use JMS\Serializer\Annotation as JMS;
use ShipAndCoSDK\Common\Setup as CommonSetup;
use ShipAndCoSDK\Responses\Types\Setup\Care;
use ShipAndCoSDK\Responses\Types\Setup\CashOnDelivery;

/**
 * @property-read string $carrier
 * @property-read string $carrier_id
 * @property-read string $service
 * @property-read string $currency
 * @property-read DateTimeInterface $shipment_date
 * @property-read DateTimeInterface $date
 * @property-read string $time
 * @property-read float|int $insurance
 * @property-read string $ref_number
 * @property-read string $delivery_note
 * @property-read float|int $discount
 * @property-read bool $signature
 * @property-read string $cool_options
 * @property-read Care $care
 * @property-read int $pack_size
 * @property-read int $pack_amount
 * @property-read CashOnDelivery $cash_on_delivery
 * @property-read bool $return_label
 * @property-read int $print_start_location
 * @property-read float $shipping_fee
 * @property-read bool $security_service
 * @property-read string $consignee_tax_id
 * @property-read bool $test
 */
final class Setup extends CommonSetup
{
    use PropertyRead;

    /**
     * @JMS\Type("ShipAndCoSDK\Responses\Types\Setup\Care")
     *
     * @var Care
     */
    private $care;

    /**
     * @JMS\Type("ShipAndCoSDK\Responses\Types\Setup\CashOnDelivery")
     *
     * @var CashOnDelivery
     */
    private $cash_on_delivery;
}
