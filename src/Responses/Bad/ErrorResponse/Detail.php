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

namespace ShipAndCoSDK\Responses\Bad\ErrorResponse;

use CommonSDK\Concerns\PropertyRead;
use CommonSDK\Contracts\HasErrorCode;
use JMS\Serializer\Annotation as JMS;

/**
 * @property-read string $code
 * @property-read string $message
 * @property-read string $field
 * @property-read string|null $issue
 * @property-read int|null $value
 */
final class Detail implements HasErrorCode
{
    use PropertyRead;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $code;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $message;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $field;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $issue;

    /**
     * This might be an int, or an array. Currently we deserialize ints only. This requires a custom handler, an implementation of SubscribingHandlerInterface.
     *
     * @see https://github.com/docteurklein/event-store/blob/master/src/Knp/Event/Serializer/Jms/Handler/Event/Generic.php
     *
     * @JMS\Type("int")
     *
     * @var int|string[]
     */
    private $value;

    public function getErrorCode(): ?string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message ?? '';
    }
}
