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
use JMS\Serializer\Annotation as JMS;
use ShipAndCoSDK\Responses\Types\Rate\Surcharge;

/**
 * @property-read string            $carrier
 * @property-read string            $service
 * @property-read string            $currency
 * @property-read float             $price
 * @property-read Surcharge[]       $surcharges
 */
final class Rate
{
    use PropertyRead;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $carrier;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $service;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $currency;

    /**
     * @JMS\Type("float")
     *
     * @var float
     */
    private $price;

    /**
     * @JMS\Type("array<ShipAndCoSDK\Responses\Types\Rate\Surcharge>")
     *
     * @var Surcharge[]
     */
    private $surcharges = [];
}
