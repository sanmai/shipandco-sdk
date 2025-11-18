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

namespace Tests\ShipAndCoSDK\Serialization;

use ShipAndCoSDK\Requests\RegisterCarrierRequest;

/**
 * @covers \ShipAndCoSDK\Requests\RegisterCarrierRequest
 */
class RegisterCarrierRequestTest extends TestCase
{
    public function test_dhl_registration()
    {
        $request = new RegisterCarrierRequest();

        $request->type = 'dhl';
        $request->credentials->account_number = '123456789';
        $request->credentials->site_id = 'SITE123';
        $request->credentials->password = 'secret_password';
        $request->credentials->address->company = 'World Company';
        $request->credentials->address->phone = '08042428484';
        $request->credentials->address->email = 'test@gmail.com';
        $request->credentials->address->address1 = 'Nakagyo-ku, Yaoyacho';
        $request->credentials->address->zip = '6048072';
        $request->credentials->address->city = 'Kyoto';
        $request->credentials->address->country = 'JP';

        $request->settings->print->size = 'PDF_A4';

        $this->assertSameAsFixture('RegisterCarrierRequest_dhl.json', $request);
    }

    public function test_fedex_registration()
    {
        $request = new RegisterCarrierRequest();

        $request->type = 'fedex';
        $request->credentials->account_number = '987654321';
        $request->credentials->password = 'fedex_secret';
        $request->credentials->invoice_2fa = true;
        $request->credentials->address->company = 'FedEx Test Company';
        $request->credentials->address->full_name = 'John Doe';
        $request->credentials->address->phone = '+12025551234';
        $request->credentials->address->email = 'john@example.com';
        $request->credentials->address->address1 = '123 Main Street';
        $request->credentials->address->address2 = 'Suite 100';
        $request->credentials->address->zip = '20001';
        $request->credentials->address->city = 'Washington';
        $request->credentials->address->country = 'US';

        $request->settings->print->size = 'PDF_A4';

        $this->assertSameAsFixture('RegisterCarrierRequest_fedex.json', $request);
    }

    public function test_yamato_registration()
    {
        $request = new RegisterCarrierRequest();

        $request->type = 'yamato';
        $request->credentials->key = 'yamato_api_key_123';
        $request->credentials->freight_number = '01';

        $request->settings->print->size = 'PDF_A4';
        $request->settings->label->delivery_date = true;
        $request->settings->scheduled_delivery_email = 'notify@example.com';

        $this->assertSameAsFixture('RegisterCarrierRequest_yamato.json', $request);
    }
}
