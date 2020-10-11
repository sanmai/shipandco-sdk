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

namespace ShipAndCoSDK\Responses\Bad;

use CommonSDK\Concerns\PropertyRead;
use CommonSDK\Contracts\HasErrorCode;
use CommonSDK\Contracts\Response;
use CommonSDK\Types\Message;
use Countable;
use JMS\Serializer\Annotation as JMS;
use ShipAndCoSDK\Responses\Bad\ErrorResponse\Detail;

/**
 * Generic error response.
 *
 * @property-read bool|null $auth
 * @property-read string|null $debug_id
 * @property-read string|null $code
 * @property-read string $message
 * @property-read Detail[]|array<Detail> $details
 * @property-read string $link
 * @property-read string|null $description
 */
final class ErrorResponse implements Response, HasErrorCode, Countable
{
    use PropertyRead;

    private const AUTH_ERROR = 'AUTH';

    /**
     * @JMS\Type("bool")
     *
     * @var ?bool
     */
    private $auth;

    /**
     * @JMS\Type("string")
     *
     * @var ?string
     */
    private $debug_id;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    private $code;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $message;

    /**
     * @JMS\Type("array<ShipAndCoSDK\Responses\Bad\ErrorResponse\Detail>")
     *
     * @var Detail[]
     */
    private $details = [];

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    private $link;

    /**
     * @JMS\Type("string")
     *
     * @var string|null
     */
    private $description;

    public function hasErrors(): bool
    {
        return true;
    }

    public function getMessages()
    {
        return Message::from([$this], $this->details);
    }

    public function getErrorCode(): ?string
    {
        if ($this->auth === false) {
            // Some error responses have no code
            return $this->code ?? self::AUTH_ERROR;
        }

        return $this->code;
    }

    public function getMessage(): string
    {
        return (string) ($this->message ?? $this->description ?? $this->debug_id);
    }

    public function count()
    {
        return 0;
    }
}
