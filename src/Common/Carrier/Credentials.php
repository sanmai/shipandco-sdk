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

namespace ShipAndCoSDK\Common\Carrier;

use JMS\Serializer\Annotation as JMS;

abstract class Credentials
{
    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $account_number;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $site_id;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $password;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $import_acc_number;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $access_key;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $user_name;

    /**
     * @JMS\Type("array<string>")
     *
     * @var string[]|null
     */
    protected $customer_numbers;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $key;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $freight_number;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $user_id;

    /**
     * Invoice details for FedEx 2FA verification.
     *
     * @JMS\Type("ShipAndCoSDK\Common\Carrier\Invoice2fa")
     *
     * @var Invoice2fa|null
     */
    protected $invoice_2fa;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    protected $niokurinin;
}
