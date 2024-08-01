# PHPUnit TestListener for PHP-VCR

[![CI Tests](https://github.com/covergenius/phpunit-testlistener-vcr/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/covergenius/phpunit-testlistener-vcr/actions)
[![License](https://img.shields.io/packagist/l/covergenius/phpunit-testlistener-vcr.svg?style=flat-square)](LICENSE)
[![Development Version](https://img.shields.io/packagist/vpre/covergenius/phpunit-testlistener-vcr.svg?style=flat-square)](https://packagist.org/packages/covergenius/phpunit-testlistener-vcr)
[![Monthly Installs](https://img.shields.io/packagist/dm/covergenius/phpunit-testlistener-vcr.svg?style=flat-square)](https://packagist.org/packages/covergenius/phpunit-testlistener-vcr)

Integrates PHPUnit with [PHP-VCR](http://github.com/covergenius/php-vcr) using annotations.

![PHP-VCR](https://user-images.githubusercontent.com/133832/27151811-0d95c6c4-514c-11e7-834e-eff1eec2ea16.png)

Use `@vcr cassette_name` on your tests to turn VCR automatically on and off.



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
composer require --dev covergenius/phpunit-testlistener-vcr
```

### For phpunit version 10+

2) Add listener to your `phpunit.xml`:

``` xml
<extensions>
    <bootstrap class="VCR\PHPUnit\TestListener\VCRTestListener" />
</extensions>
```

### For phpunit version 9 and below
``` xml
<listeners>
    <listener class="VCR\PHPUnit\TestListener\VCRTestListener" file="vendor/covergenius/phpunit-testlistener-vcr/src/VCRTestListener.php" />
</listeners>
```

## Dependencies
PHPUnit-Testlistener-VCR depends on the following;

* [php-vcr/php-vcr](https://github.com/covergenius/php-vcr)

### Version 4
* PHP 8.1+
* PHPUnit >=10

### Version 3

* PHP 7.1+
* PHPUnit <10 


## Run tests

In order to run all tests you need to get development dependencies using composer:

``` php
composer install
./vendor/bin/phpunit
```

## Changelog

**The changelog is manage at [PHPUnit testlistener for PHP-VCR releases page](https://github.com/covergenius/phpunit-testlistener-vcr/releases).**

## Copyright
Copyright (c) 2013-2018 Adrian Philipp. Released under the terms of the MIT license. See LICENSE for details.
[Contributors](https://github.com/covergenius/phpunit-testlistener-vcr/graphs/contributors)
