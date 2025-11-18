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

// Example 1: Register DHL carrier
$request = new \ShipAndCoSDK\Requests\RegisterCarrierRequest();

$request->type = 'dhl';
$request->credentials->account_number = '123456789';
$request->credentials->site_id = 'YOUR_DHL_SITE_ID';
$request->credentials->password = 'YOUR_DHL_PASSWORD';
$request->credentials->address->company = 'Your Company Name';
$request->credentials->address->phone = '08012345678';
$request->credentials->address->email = 'your@email.com';
$request->credentials->address->address1 = 'Your Address';
$request->credentials->address->zip = '1234567';
$request->credentials->address->city = 'Your City';
$request->credentials->address->country = 'JP';

$request->settings->print->size = 'PDF_A4';

echo "Registering DHL carrier...\n";

$response = $client->sendRegisterCarrierRequest($request);

if ($response->hasErrors()) {
    echo "Error registering carrier:\n";
    foreach ($response->getMessages() as $message) {
        if ($message->getErrorCode() !== '') {
            echo "{$message->getErrorCode()}: {$message->getMessage()}\n";
        }
    }
    exit(1);
}

echo "Carrier registered successfully!\n";
echo "ID: {$response->id}\n";
echo "Type: {$response->type}\n";
echo "State: {$response->state}\n";
echo "Created: {$response->created_at->format('Y-m-d H:i:s')}\n";

// Example 2: Register FedEx carrier (commented out)
/*
$request = new \ShipAndCoSDK\Requests\RegisterCarrierRequest();

$request->type = 'fedex';
$request->credentials->account_number = 'YOUR_FEDEX_ACCOUNT';
$request->credentials->password = 'YOUR_FEDEX_PASSWORD';
$request->credentials->invoice_2fa = true; // Required for API registration
$request->credentials->address->company = 'Your Company Name';
$request->credentials->address->full_name = 'Your Name';
$request->credentials->address->phone = '+12025551234';
$request->credentials->address->email = 'your@email.com';
$request->credentials->address->address1 = '123 Main Street';
$request->credentials->address->address2 = 'Suite 100';
$request->credentials->address->zip = '20001';
$request->credentials->address->city = 'Washington';
$request->credentials->address->country = 'US';

$request->settings->print->size = 'PDF_A4';

$response = $client->sendRegisterCarrierRequest($request);

if (!$response->hasErrors()) {
    echo "FedEx carrier registered successfully!\n";
    echo "ID: {$response->id}\n";
}
*/
