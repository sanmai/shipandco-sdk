# Ship&amp;co API integration SDK

[![Latest Stable Version](https://poser.pugx.org/sanmai/shipandco-sdk/v/stable)](https://packagist.org/packages/sanmai/shipandco-sdk)
[![Build Status](https://travis-ci.com/sanmai/shipandco-sdk.svg?branch=master)](https://travis-ci.com/sanmai/shipandco-sdk)
[![Coverage Status](https://coveralls.io/repos/github/sanmai/shipandco-sdk/badge.svg?branch=master)](https://coveralls.io/github/sanmai/shipandco-sdk?branch=master)

Features:

- [ ] Shipments
  - [x] Create Shipment
  - [ ] List Shipments
  - [ ] Get Shipment
  - [ ] Delete Shipment
- [x] Rate
  - [x] List Rates
- [ ] Carrier
  - [ ] Register Carrier
  - [x] List Carriers
  - [ ] Update Carrier
  - [ ] Delete Carrier
- [ ] Tracking
- [ ] Address
  - [ ] Register Address
  - [x] List Addresses
- [ ] Warehouse
  - [ ] Register Warehouse
  - [x] List Warehouses
- [ ] Sub User
  - [ ] Register Sub User
  - [ ] List Sub User
  - [ ] Get Sub User
  - [ ] Refresh Sub User
  - [ ] Delete Sub User

This library is far from offering a complete set of API methods, but it should do the most important bits.

**Something is amiss?(()) [Let us know](https://github.com/sanmai/shipandco-sdk/issues/new/choose), or, even better, send a PR!

[Ship&amp;co API documentation.](https://developer.shipandco.com/en/)

## Installation

```bash
composer require sanmai/shipandco-sdk
```

This SDK requires at least PHP 7.3. It was tested to work under PHP 7.3, 7.4, and 8.0.

## Overview

Major parts are:

- Client. Client is the object you send all requests through.
- Requests. There are several request objects for most requests the API offers. They follow a fluent interface paradigm, where if the original request has a certain property, a request here will have it too. More on this below.  
- Responses. After sending a request you'll have a response object, which could be an actual reponse, or an error response. All responses follow the same fluent paradigm.

## Usage

First, you need to acquire an access token [as outlined in the documentation](https://developer.shipandco.com/en/#t-auth).

Next, instantiate a client using a convenient builder:

```php
$builder = new \ShipAndCoSDK\ClientBuilder();
$builder->setToken($token);

$client = $builder->build();
``` 

The builder has several more convenience methods to set timeouts and enable caching. Check with the source code.

### Error handling

Error handling is built upon error responses. Exceptions are almost never thrown. If there's an exception, this has to be a truly exceptional situation, even a bug.

```php
$request = new \ShipAndCoSDK\Requests\RatesRequest();

// This requests requires several properties to be set, therefore we'll have an error here.
$response = $client->sendRatesRequest($request);

if (\count($response) > 0) {
    // Will not be printed because count() is zero here.
    echo 'Rates received: ', \count($response), "\n";
}

if ($response->hasErrors()) {
    // Check for exact errors
    foreach ($response->getMessages() as $message) {
        if ($message->getErrorCode() !== '') {
            // That's the error:
            echo "{$message->getErrorCode()}: {$message->getMessage()}\n";
        }
    }

    /** @var \ShipAndCoSDK\Responses\Bad\ErrorResponse $response */
    
    // To get more specific error details use response-specific fields. E.g.:
    foreach ($response->details as $detail) {
        echo "Error code: {$detail->code}\n\tMessage: {$detail->message}\n\tField: {$detail->field}\n";
    }
}
```

### List Carriers

```php
$request = new \ShipAndCoSDK\Requests\CarriersRequest();

$response = $client->sendCarriersRequest($request);

\var_dump(\count($response)); // Should print the number of configured carriers

foreach ($response as $value) {
    echo "{$value->id}\t{$value->type}\t{$value->state}\t{$value->created_at->format('Y-m-d')}\n";
    
    foreach ($value->credentials as $key => $value) {
        echo "\t$key =\t$value\n";
    }
}
```

### List Addresses

```php
$request = new \ShipAndCoSDK\Requests\AddressesRequest();

$response = $client->sendAddressesRequest($request);

\var_dump(\count($response)); // Should print the number of addresses returned

foreach ($response as $value) {
    echo "{$value->id}\t{$value->created_at->format('Y-m-d')}\n";
    
    foreach ($value->address as $key => $value) {
        echo "\t$key =\t$value\n";
    }
}
```

### List Warehouses

```php
$request = new \ShipAndCoSDK\Requests\WarehousesRequest();

$response = $client->sendWarehousesRequest($request);

\var_dump(\count($response)); // Should print the number of warehouses returned

foreach ($response as $value) {
    echo "{$value->id}\t{$value->created_at->format('Y-m-d')}\t{$value->company}\n";
    
    foreach ($value->address as $key => $value) {
        echo "\t$key =\t$value\n";
    }
}
```

### List Rates

```php
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
        echo "\t{$surcharge->type}\t{$surcharge->amount}\n";
    }
}
```

### Create Shipment

```

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
```

To safeguard you against unexpected billing charges, shipment requests are [using the test environment](https://developer.shipandco.com/en/#t-ship_post) by default (thus creating dummy labels). Make sure to set `test` to `false` in `setup` section to receive live labels.

Just like so:

```php
$request->setup->test = false;
```

## License

This project is licensed [under the terms of the MIT license](LICENSE).




