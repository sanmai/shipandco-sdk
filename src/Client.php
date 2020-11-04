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

namespace ShipAndCoSDK;

use CommonSDK\Contracts\Response;
use CommonSDK\Types\Client as CommonClient;
use Psr\Http\Message\ResponseInterface;
use ShipAndCoSDK\Responses\Bad\ErrorResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Ship&Co API Client.
 *
 * @method Responses\CarriersResponse|Responses\Types\Carrier[]               sendCarriersRequest(Requests\CarriersRequest $request)
 * @method Responses\AddressesResponse|Responses\Types\Address\DatedWrapper[] sendAddressesRequest(Requests\AddressesRequest $request)
 * @method Responses\AddressesResponse|Responses\Types\Address\DatedWrapper[] sendWarehousesRequest(Requests\WarehousesRequest $request)
 * @method Responses\RatesResponse|Responses\Types\Rate[]                     sendRatesRequest(Requests\RatesRequest $request)
 * @method Responses\ShipmentResponse                                         sendCreateShipmentRequest(Requests\CreateShipmentRequest $request)
 */
final class Client extends CommonClient
{
    protected const ERROR_CODE_RESPONSE_CLASS_MAP = [
        HttpResponse::HTTP_BAD_REQUEST                => ErrorResponse::class, // 400   Validation errors due to incorrect or insufficient input
        HttpResponse::HTTP_FORBIDDEN                  => ErrorResponse::class, // 403	The API token is not specified or is incorrect
        HttpResponse::HTTP_NOT_FOUND                  => ErrorResponse::class, // 404	The specified data is not found
        HttpResponse::HTTP_TOO_MANY_REQUESTS          => ErrorResponse::class, // 429	Too many requests
        HttpResponse::HTTP_INTERNAL_SERVER_ERROR      => ErrorResponse::class, // 500	Internal errors
    ];

    protected function postDeserialize(ResponseInterface $httpResponse, Response $response): void
    {
    }
}
