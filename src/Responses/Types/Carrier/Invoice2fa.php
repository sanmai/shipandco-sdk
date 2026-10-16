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
use ShipAndCoSDK\Common\Carrier\Invoice2fa as BaseInvoice2fa;

/**
 * Invoice details for FedEx 2FA verification.
 *
 * @property-read string $number   The invoice number from the latest FedEx invoice
 * @property-read string $date     The invoice date in YYYY-MM-DD format
 * @property-read float  $amount   The total amount on the invoice
 * @property-read string $currency The currency code (e.g., JPY, USD)
 */
final class Invoice2fa extends BaseInvoice2fa implements IteratorAggregate
{
    use PropertyRead;
    use PropertyIterator;
}
