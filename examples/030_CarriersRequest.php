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

$builder = new \ShipAndCoSDK\ClientBuilder();
$builder->setToken($_SERVER['SHIPANDCO_ACCESS_TOKEN'] ?? '');
$builder->setLogger(new DebuggingLogger());

/** @var \ShipAndCoSDK\Client $client */
$client = $builder->build();

$request = new \ShipAndCoSDK\Requests\CarriersRequest();

$response = $client->sendCarriersRequest($request);

var_dump(count($response));

foreach ($response as $value) {
    echo "{$value->id}\t{$value->type}\t{$value->state}\t{$value->created_at->format('Y-m-d')}\n";
    foreach ($value->credentials as $key => $value) {
        echo "\t$key =\t$value\n";
    }
}
