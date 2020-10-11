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

$request = new \ShipAndCoSDK\Requests\CreateShipmentRequest();

$request->to_address->country = 'JP';
$request->to_address->full_name = 'TEST TARO';
$request->to_address->phone = '1111111111';
$request->to_address->country = 'JP';
$request->to_address->address1 = '京都市中京区八百屋町117';
$request->to_address->zip = '604-8072';
$request->to_address->city = '京都府';

$request->from_address->full_name = 'テスト';
$request->from_address->phone = '08012341234';
$request->from_address->country = 'JP';
$request->from_address->address1 = 'OSAKAFU';
$request->from_address->province = 'OSAKA';
$request->from_address->zip = '1234567';
$request->from_address->city = 'IBARAKI SHI';

$product = $request->addProduct();
$product->name = 'Blue Basketball';
$product->quantity = 2;
$product->price = 4850;
$product->origin_country = 'JP';

$product = $request->addProduct();
$product->name = 'Orange Basketball';
$product->quantity = 1;
$product->price = 7850;
$product->origin_country = 'JP';

$parcel = $request->addParcel();
$parcel->amount = 1; // That's the default.
$parcel->weight = 2000;
$parcel->width = 10;
$parcel->height = 10;
$parcel->depth = 10;
// $parcel->package = 'fedex_envelope';

$request->customs->duty_paid = false;
$request->customs->content_type = 'MERCHANDISE';

$request->setup->carrier = 'sagawa';
$request->setup->service = 'sagawa_regular';
$request->setup->currency = 'JPY';
$request->setup->shipment_date = new DateTime('+1 day');
$request->setup->date = new DateTime('+2 day');
$request->setup->time = '16-18';
$request->setup->insurance = 0;
$request->setup->ref_number = '';
$request->setup->delivery_note = '';
$request->setup->signature = false;
$request->setup->care->fragile = false;
$request->setup->care->side_up = false;
$request->setup->care->valuable_goods = false;
$request->setup->pack_size = '0';
$request->setup->pack_amount = 3;
$request->setup->cash_on_delivery->amount = 1000;
$request->setup->cash_on_delivery->tax = 100;
$request->setup->return_label = false;
$request->setup->print_start_location = 1;
$request->setup->test = true;

$response = $client->sendCreateShipmentRequest($request);

if ($response->hasErrors()) {
    // Check for exact errors
    foreach ($response->getMessages() as $message) {
        if ($message->getErrorCode() !== '') {
            // That's the error
            echo "{$message->getErrorCode()}: {$message->getMessage()}\n";
        }
    }

    return; // This is a failure.
}

/** @var $response \ShipAndCoSDK\Responses\ShipmentResponse */
echo "{$response->id}\t{$response->state}\n";

echo "Shipping Label: {$response->delivery->label}\n";

foreach ($response->delivery->tracking_numbers as $trackingNumber) {
    echo "Tracking Number: {$trackingNumber}\n";
}
