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

use CommonSDK\Concerns\PropertyIterator;
use IteratorAggregate;
use JMS\Serializer\Annotation as JMS;

/**
 * Common address fields, good for both mailing addresses and warehouses.
 *
 * @template-implements IteratorAggregate<string, mixed>
 */
abstract class Address implements IteratorAggregate
{
    use PropertyIterator;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $address1;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $address1_kanji;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $address2;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $address2_kanji;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $address3;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $address3_kanji;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $city;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $company;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $company_kanji;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $country;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $email;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $full_name;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $full_name_kanji;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $phone;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $province;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $province_kanji;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $zip;
}
