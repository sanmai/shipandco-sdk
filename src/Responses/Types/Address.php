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
use ShipAndCoSDK\Common\Address as CommonAddress;

/**
 * @property-read string|null $address1
 * @property-read string|null $address1_kanji
 * @property-read string|null $address2
 * @property-read string|null $address2_kanji
 * @property-read string|null $address3
 * @property-read string|null $address3_kanji
 * @property-read string|null $city
 * @property-read string|null $company
 * @property-read string|null $company_kanji
 * @property-read string|null $country
 * @property-read string|null $email
 * @property-read string|null $full_name
 * @property-read string|null $full_name_kanji
 * @property-read string|null $phone
 * @property-read string|null $province
 * @property-read string|null $province_kanji
 * @property-read string|null $zip
 */
final class Address extends CommonAddress
{
    use PropertyRead;
}
