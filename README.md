# PHPUnit Testlistener for PHP-VCR

Integrates PHPUnit with [PHP-VCR](http://github.com/php-vcr/php-vcr) using annotations.

![PHP-VCR](https://dl.dropbox.com/u/13186339/blog/php-vcr.png)

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

  * PHP 7.0+
  * [php-vcr/php-vcr](https://github.com/php-vcr/php-vcr)
  * [PHPUnit](https://phpunit.de/#supported-versions) 6

## Run tests

In order to run all tests you need to get development dependencies using composer:

``` php
composer install
./vendor/bin/phpunit
```

## Changelog

**The changelog is manage at [PHPUnit testlistener for PHP-VCR releases page](https://github.com/php-vcr/phpunit-testlistener-vcr/releases).**

## Copyright
Copyright (c) 2013-2017 Adrian Philipp. Released under the terms of the MIT license. See LICENSE for details.
