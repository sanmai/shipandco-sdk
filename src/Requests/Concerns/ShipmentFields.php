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

namespace ShipAndCoSDK\Requests\Concerns;

use JMS\Serializer\Annotation as JMS;
use ShipAndCoSDK\Requests\Types\Address;
use ShipAndCoSDK\Requests\Types\Customs;
use ShipAndCoSDK\Requests\Types\Parcel;
use ShipAndCoSDK\Requests\Types\Product;
use ShipAndCoSDK\Requests\Types\Setup;

/**
 * @property-read Address $to_address
 * @property-read Address $from_address
 * @property-read Customs $customs
 * @property-read Setup   $setup
 */
trait ShipmentFields
{
    /**
     * @JMS\Type("ShipAndCoSDK\Requests\Types\Address")
     *
     * @var Address
     */
    private $to_address;

    /**
     * @JMS\Type("ShipAndCoSDK\Requests\Types\Address")
     *
     * @var Address
     */
    private $from_address;

    /**
     * @JMS\Type("array<ShipAndCoSDK\Requests\Types\Product>")
     *
     * @var Product[]
     */
    private $products = [];

    /**
     * @JMS\Type("array<ShipAndCoSDK\Requests\Types\Parcel>")
     *
     * @var Parcel[]
     */
    private $parcels = [];

    /**
     * @JMS\Type("ShipAndCoSDK\Requests\Types\Customs")
     *
     * @var Customs
     */
    private $customs;

    /**
     * @JMS\Type("ShipAndCoSDK\Requests\Types\Setup")
     *
     * @var Setup
     */
    private $setup;

    /**
     * @phan-suppress PhanAccessReadOnlyMagicProperty
     */
    public function __construct(Address $to_address = null, Address $from_address = null, Customs $customs = null, Setup $setup = null)
    {
        $this->to_address = $to_address ?? new Address();
        $this->from_address = $from_address ?? new Address();
        $this->customs = $customs ?? new Customs();
        $this->setup = $setup ?? new Setup();
    }

    public function addParcel(): Parcel
    {
        $parcel = new Parcel();

        $this->addParcels($parcel);

        return $parcel;
    }

    /**
     * @param Parcel ...$parcels
     */
    public function addParcels(...$parcels): self
    {
        foreach ($parcels as $parcel) {
            $this->parcels[] = $parcel;
        }

        return $this;
    }

    public function addProduct(): Product
    {
        $product = new Product();

        $this->addProducts($product);

        return $product;
    }

    /**
     * @param Product ...$products
     */
    public function addProducts(...$products): self
    {
        foreach ($products as $product) {
            $this->products[] = $product;
        }

        return $this;
    }
}
