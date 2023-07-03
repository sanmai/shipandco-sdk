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

use Tests\ShipAndCoSDK\Integration\DebuggingLogger;

include_once 'vendor/autoload.php';

/*
 * Authorization error.
 */
$builder = new \ShipAndCoSDK\ClientBuilder();
$builder->setToken('invalid');
$builder->setLogger(new DebuggingLogger());

/** @var \ShipAndCoSDK\Client $client */
$client = $builder->build();

$request = new \ShipAndCoSDK\Requests\CarriersRequest();

$response = $client->sendCarriersRequest($request);

if ($response->hasErrors()) {
    // Check for exact errors
    foreach ($response->getMessages() as $message) {
        if ($message->getErrorCode() !== '') {
            // That's the error
            echo "{$message->getErrorCode()}: {$message->getMessage()}\n";
        }
    }
}

/*
 * Correct token, but incorrect request.
 */
$builder = new \ShipAndCoSDK\ClientBuilder();
$builder->setToken($_SERVER['SHIPANDCO_ACCESS_TOKEN'] ?? '');
$builder->setLogger(new DebuggingLogger());

/** @var \ShipAndCoSDK\Client $client */
$client = $builder->build();

$request = new \ShipAndCoSDK\Requests\RatesRequest();

$response = $client->sendRatesRequest($request);

if (count($response) > 0) {
    // Will not be printed because count() is zero here
    echo 'Rates received: ', count($response), "\n";
}

if ($response->hasErrors()) {
    // Check for exact errors
    foreach ($response->getMessages() as $message) {
        if ($message->getErrorCode() !== '') {
            // That's the error
            echo "{$message->getErrorCode()}: {$message->getMessage()}\n";
        }
    }

    echo "\n";

    /** @var \ShipAndCoSDK\Responses\Bad\ErrorResponse $response */

    // To get more specific error details use response-specific fields. E.g.:
    foreach ($response->details as $detail) {
        echo "Error code: {$detail->code}\n\tMessage: {$detail->message}\n\tField: {$detail->field}\n";
    }
}
