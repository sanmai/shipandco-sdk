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

namespace ShipAndCoSDK\Requests\Types\Carrier;

use CommonSDK\Concerns\PropertyWrite;
use CommonSDK\Contracts\ReadableRequestProperty;
use ShipAndCoSDK\Common\Carrier\CredentialsAddress as CommonCredentialsAddress;

/**
 * @property-write string|null $company
 * @property-write string|null $phone
 * @property-write string|null $email
 * @property-write string|null $address1
 * @property-write string|null $address2
 * @property-write string|null $full_name
 * @property-write string|null $zip
 * @property-write string|null $city
 * @property-write string|null $country
 */
final class CredentialsAddress extends CommonCredentialsAddress implements ReadableRequestProperty
{
    use PropertyWrite;
}
