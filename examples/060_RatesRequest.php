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

$request = new \ShipAndCoSDK\Requests\RatesRequest();

$request->from_address->country = 'JP';
$request->from_address->full_name = 'Yamada Taro';
$request->from_address->company = 'World Company';
$request->from_address->email = 'ytaro@example.com';
$request->from_address->phone = '08012341234';
$request->from_address->country = 'JP';
$request->from_address->address1 = 'OSAKAFU';
$request->from_address->address2 = 'OTECHO';
$request->from_address->province = 'OSAKA';
$request->from_address->zip = '5670883';
$request->from_address->city = 'IBARAKI SHI';

$request->to_address->full_name = 'John Doe';
$request->to_address->company = 'ACME';
$request->to_address->email = 'john@example.net';
$request->to_address->phone = '0901231234';
$request->to_address->country = 'PT';
$request->to_address->address1 = 'Rua Maria Matos, 32';
$request->to_address->address2 = '';
$request->to_address->province = 'SETUBAL';
$request->to_address->zip = '2820-344';
$request->to_address->city = 'CHARNECA DA CAPARICA';

$product = $request->addProduct();
$product->quantity = 1;
$product->name = 'Example';
$product->price = 1000;

$parcel = $request->addParcel();
$parcel->weight = 200;
$parcel->width = 10;
$parcel->height = 10;
$parcel->depth = 10;

$request->customs->duty_paid = false;
$request->customs->content_type = 'MERCHANDISE';

$request->setup->date = new DateTime('+1 week');

$response = $client->sendRatesRequest($request);

\var_dump(\count($response));

foreach ($response as $rate) {
    echo "{$rate->carrier}\t{$rate->service}\t{$rate->price} {$rate->currency}\n";

    foreach ($rate->surcharges as $surcharge) {
        echo "\t{$surcharge->type}\t{$surcharge->price}\n";
    }
}
