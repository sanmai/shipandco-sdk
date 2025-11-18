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

namespace ShipAndCoSDK\Responses\Types\Carrier;

use CommonSDK\Concerns\PropertyIterator;
use CommonSDK\Concerns\PropertyRead;
use IteratorAggregate;
use JMS\Serializer\Annotation as JMS;

/**
 * @property-read string $user_id
 * @property-read string $key
 * @property-read string $freight_number
 * @property-read string $password
 * @property-read string $account_number
 * @property-read string $account_key_number
 * @property-read string $customer_numbers
 * @property-read string $site_id
 * @property-read Invoice2fa $invoice_2fa
 */
final class Credentials implements IteratorAggregate
{
    use PropertyRead;
    use PropertyIterator;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $user_id;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $key;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $freight_number;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $password;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $account_number;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $account_key_number;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $customer_numbers;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $site_id;

    /**
     * Invoice details for FedEx 2FA verification.
     *
     * @JMS\Type("ShipAndCoSDK\Responses\Types\Carrier\Invoice2fa")
     *
     * @var Invoice2fa
     */
    private $invoice_2fa;
}
