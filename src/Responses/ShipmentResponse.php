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

namespace ShipAndCoSDK\Responses;

use CommonSDK\Concerns\PropertyRead;
use CommonSDK\Concerns\SuccessfulResponse;
use CommonSDK\Contracts\Response;
use DateTimeImmutable;
use JMS\Serializer\Annotation as JMS;
use ShipAndCoSDK\Responses\Types\Address;
use ShipAndCoSDK\Responses\Types\Customs;
use ShipAndCoSDK\Responses\Types\Delivery;
use ShipAndCoSDK\Responses\Types\Parcel;
use ShipAndCoSDK\Responses\Types\Product;
use ShipAndCoSDK\Responses\Types\Setup;

/**
 * @property-read string $id
 * @property-read string $state
 * @property-read bool $test
 * @property-read DateTimeImmutable $created_at
 * @property-read Address $to_address
 * @property-read Product[] $products
 * @property-read Address $from_address
 * @property-read Parcel[] $parcels
 * @property-read Customs $customs
 * @property-read Setup $setup
 * @property-read Delivery $delivery
 */
final class ShipmentResponse implements Response
{
    use PropertyRead;
    use SuccessfulResponse;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $id;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $state;

    /**
     * @JMS\Type("bool")
     *
     * @var bool
     */
    private $test;

    /**
     * @JMS\Type("DateTimeImmutable<'Y-m-d\TH:i:s.uO'>")
     *
     * @var DateTimeImmutable
     */
    private $created_at;

    /**
     * @JMS\Type("ShipAndCoSDK\Responses\Types\Address")
     *
     * @var Address
     */
    private $to_address;

    /**
     * @JMS\Type("ShipAndCoSDK\Responses\Types\Address")
     *
     * @var Address
     */
    private $from_address;

    /**
     * @JMS\Type("array<ShipAndCoSDK\Responses\Types\Product>")
     *
     * @var Product[]
     */
    private $products = [];

    /**
     * @JMS\Type("array<ShipAndCoSDK\Responses\Types\Parcel>")
     *
     * @var Parcel[]
     */
    private $parcels = [];

    /**
     * @JMS\Type("ShipAndCoSDK\Responses\Types\Customs")
     *
     * @var Customs
     */
    private $customs;

    /**
     * @JMS\Type("ShipAndCoSDK\Responses\Types\Setup")
     *
     * @var Setup
     */
    private $setup;

    /**
     * @JMS\Type("ShipAndCoSDK\Responses\Types\Delivery")
     *
     * @var Delivery
     */
    private $delivery;
}
