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

namespace ShipAndCoSDK\Common;

use DateTimeInterface;
use JMS\Serializer\Annotation as JMS;

abstract class Setup
{
    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $carrier;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $service;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $currency;

    /**
     * @JMS\Type("DateTimeInterface<'Y-m-d'>")
     *
     * @var DateTimeInterface
     */
    protected $shipment_date;

    /**
     * @JMS\Type("DateTimeInterface<'Y-m-d'>")
     *
     * @var DateTimeInterface
     */
    protected $date;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $time;

    /**
     * @JMS\Type("float")
     *
     * @var float
     */
    protected $insurance;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $ref_number;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $delivery_note;

    /**
     * @JMS\Type("float")
     *
     * @var float
     */
    protected $discount;

    /**
     * @JMS\Type("bool")
     *
     * @var bool
     */
    protected $signature;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $pack_size;

    /**
     * @JMS\Type("int")
     *
     * @var int
     */
    protected $pack_amount;

    /**
     * @JMS\Type("bool")
     *
     * @var bool
     */
    protected $return_label;

    /**
     * @JMS\Type("int")
     *
     * @var int
     */
    protected $print_start_location;

    /**
     * @JMS\Type("bool")
     *
     * @var bool
     */
    protected $test = true;
}
