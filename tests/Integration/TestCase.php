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

use Doctrine\Common\Cache\FilesystemCache;
use ShipAndCoSDK\Client;
use ShipAndCoSDK\ClientBuilder;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    const SHIPANDCO_ACCESS_TOKEN = 'SHIPANDCO_ACCESS_TOKEN';

    /**
     * @psalm-suppress MixedArgument
     * @psalm-suppress PossiblyFalseArgument
     */
    final protected function getClient(): Client
    {
        $builder = new ClientBuilder();
        $builder->setToken(self::getEnvOrSkipTest(self::SHIPANDCO_ACCESS_TOKEN));

        if (\is_dir('build/cache/') && \class_exists(FilesystemCache::class)) {
            $builder->setCacheDir('build/cache/', true);
        }

        if (\in_array('--debug', $_SERVER['argv'])) {
            $builder->setLogger(new DebuggingLogger());
        }

        return $builder->build();
    }

    private static function getEnvOrSkipTest(string $varname): string
    {
        if (false === \getenv($varname)) {
            self::markTestSkipped(\sprintf('Integration testing disabled (%s missing).', $varname));
        }

        return (string) \getenv($varname);
    }
}
