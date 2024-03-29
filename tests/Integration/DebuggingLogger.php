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

namespace Tests\ShipAndCoSDK\Integration;

use Generator;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use ReflectionClass;

use function strtr;
use function iterator_to_array;
use function fwrite;
use function fopen;
use function dirname;
use function assert;
use function is_resource;

use const STDERR;

final class DebuggingLogger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var bool
     */
    private const WRITE_LOG_TO_FILE = false;

    /**
     * @param mixed  $level
     * @param string $message
     *
     * @psalm-suppress MixedTypeCoercion
     * @psalm-suppress TypeDoesNotContainType
     */
    public function log($level, $message, array $context = [])
    {
        if ($context) {
            $message = strtr($message, iterator_to_array(self::context2replacements($context), true));
        }

        fwrite(self::WRITE_LOG_TO_FILE ? $this->getLogFileHandle() : STDERR, "\n{$message}\n\n");
    }

    private const LOG_FILE = 'delivery-requests.log';

    /**
     * @return resource
     */
    private static function getLogFileHandle()
    {
        static $fh;

        if (!$fh) {
            $reflection = new ReflectionClass(\Composer\Autoload\ClassLoader::class);
            $fh = fopen(dirname((string) $reflection->getFileName(), 3) . DIRECTORY_SEPARATOR . self::LOG_FILE, 'a');
        }

        assert(is_resource($fh));

        return $fh;
    }

    /**
     * @param array<string, string> $context
     */
    private static function context2replacements($context): Generator
    {
        foreach ($context as $key => $value) {
            yield '{' . $key . '}' => $value;
        }
    }
}
