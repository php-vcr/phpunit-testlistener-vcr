# PHPUnit TestListener for PHP-VCR

Integrates PHPUnit with [PHP-VCR](http://github.com/php-vcr/php-vcr) using annotations.

![PHP-VCR](https://user-images.githubusercontent.com/133832/27151811-0d95c6c4-514c-11e7-834e-eff1eec2ea16.png)

Use `@vcr cassette_name` on your tests to turn VCR automatically on and off.

[![Build Status](https://travis-ci.org/php-vcr/phpunit-testlistener-vcr.svg?branch=master)](https://travis-ci.org/php-vcr/phpunit-testlistener-vcr)

## Usage example

``` php

use PHPUnit\Framework\TestCase;

class VCRTest extends TestCase
{
    /**
     * @vcr unittest_annotation_test
     */
    public function testInterceptsWithAnnotations()
    {
        // Content of tests/fixtures/unittest_annotation_test: "This is a annotation test dummy".
        $result = file_get_contents('http://google.com');
        $this->assertEquals('This is a annotation test dummy.', $result, 'Call was not intercepted (using annotations).');
    }
}
```

## Installation

1) Install using composer:

``` sh
composer require --dev php-vcr/phpunit-testlistener-vcr
```

2) Add listener to your `phpunit.xml`:

``` xml
<listeners>
    <listener class="VCR\PHPUnit\TestListener\VCRTestListener" file="vendor/php-vcr/phpunit-testlistener-vcr/src/VCRTestListener.php" />
</listeners>
```

## Dependencies

PHPUnit-Testlistener-VCR depends on:
  * PHP 7.1+
  * PHP 7.0+ (use <3.0)
  * [php-vcr/php-vcr](https://github.com/php-vcr/php-vcr)

## Run tests

In order to run all tests you need to get development dependencies using composer:

``` php
composer install
./vendor/bin/phpunit
```

## Changelog

**The changelog is manage at [PHPUnit testlistener for PHP-VCR releases page](https://github.com/php-vcr/phpunit-testlistener-vcr/releases).**

## Copyright
Copyright (c) 2013-2018 Adrian Philipp. Released under the terms of the MIT license. See LICENSE for details.
[Contributors](https://github.com/php-vcr/phpunit-testlistener-vcr/graphs/contributors)
