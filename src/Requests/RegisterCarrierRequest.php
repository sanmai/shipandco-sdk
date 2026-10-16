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

namespace ShipAndCoSDK\Requests;

use CommonSDK\Concerns\ObjectPropertyRead;
use CommonSDK\Concerns\PropertyWrite;
use CommonSDK\Concerns\RequestCore;
use CommonSDK\Contracts\JsonRequest;
use JMS\Serializer\Annotation as JMS;
use ShipAndCoSDK\Requests\Types\Carrier\Credentials;
use ShipAndCoSDK\Requests\Types\Carrier\Settings;
use ShipAndCoSDK\Responses\RegisterCarrierResponse;

/**
 * Registers a new carrier account with Ship&co.
 *
 * @property-write string $type
 * @property-read Credentials $credentials
 * @property-read Settings $settings
 */
final class RegisterCarrierRequest implements JsonRequest
{
    use RequestCore;
    use PropertyWrite;
    use ObjectPropertyRead;

    private const METHOD = 'POST';
    private const ADDRESS = '/v1/carriers';
    private const RESPONSE = RegisterCarrierResponse::class;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    private $type;

    /**
     * @JMS\Type("ShipAndCoSDK\Requests\Types\Carrier\Credentials")
     *
     * @var Credentials
     */
    private $credentials;

    /**
     * @JMS\Type("ShipAndCoSDK\Requests\Types\Carrier\Settings")
     *
     * @var Settings
     */
    private $settings;

    /**
     * @phan-suppress PhanAccessReadOnlyMagicProperty
     */
    public function __construct(?Credentials $credentials = null, ?Settings $settings = null)
    {
        $this->credentials = $credentials ?? new Credentials();
        $this->settings = $settings ?? new Settings();
    }
}
