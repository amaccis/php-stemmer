# php-stemmer

[![PHP Version](https://img.shields.io/badge/php-%5E8.1-blue.svg)](https://img.shields.io/badge/php-%5E8.1-blue.svg)
![CI](https://github.com/amaccis/php-stemmer/workflows/CI/badge.svg)

## What is PHP Stemmer?
PHP Stemmer is a PHP interface to the stemming algorithms from the [Snowball project](https://snowballstem.org/), largely inspired by Richard Boulton's [PyStemmer](https://github.com/snowballstem/pystemmer).
It uses FFI (PHP >= 7.4.0) and expects to find the file libstemmer.so (a version of [Libstemmer](https://snowballstem.org/dist/libstemmer_c.tgz) compiled as shared library) in LD_LIBRARY_PATH.  
In order to set up this kind of environment you can take a look at [docker-php-libstemmer](https://github.com/amaccis/docker-php-libstemmer) Dockerfile or you can use the corresponding docker image: [amaccis/php-libstemmer](https://hub.docker.com/r/amaccis/php-libstemmer)

## Installation

PHP Stemmer is available on [Packagist](http://packagist.org/packages/amaccis/php-stemmer), 
you can install it using [Composer](http://getcomposer.org).

```shell
composer require amaccis/php-stemmer
```

## Usage

```php
<?php

use Amaccis\Stemmer\Stemmer;
use Amaccis\Stemmer\Enum\CharacterEncodingEnum;

$algorithms = Stemmer::algorithms();
var_dump($algorithms);
/*
array(29) {
  [0] =>
  string(6) "arabic"
  [1] =>
  string(8) "armenian"
  [2] =>
  string(6) "basque"
  [3] =>
  string(7) "catalan"
  [4] =>
  string(6) "danish"
  [5] =>
  string(5) "dutch"
  [6] =>
  string(7) "english"
  [7] =>
  string(7) "finnish"
  [8] =>
  string(6) "french"
  [9] =>
  string(6) "german"
  [10] =>
  string(5) "greek"
  [11] =>
  string(5) "hindi"
  [12] =>
  string(9) "hungarian"
  [13] =>
  string(10) "indonesian"
  [14] =>
  string(5) "irish"
  [15] =>
  string(7) "italian"
  [16] =>
  string(10) "lithuanian"
  [17] =>
  string(6) "nepali"
  [18] =>
  string(9) "norwegian"
  [19] =>
  string(6) "porter"
  [20] =>
  string(10) "portuguese"
  [21] =>
  string(8) "romanian"
  [22] =>
  string(7) "russian"
  [23] =>
  string(7) "serbian"
  [24] =>
  string(7) "spanish"
  [25] =>
  string(7) "swedish"
  [26] =>
  string(5) "tamil"
  [27] =>
  string(7) "turkish"
  [28] =>
  string(7) "yiddish"
}
*/

$algorithm = "english";
$word = "cycling";
$stemmer = new Stemmer($algorithm); // default character encoding is UTF-8
$stem = $stemmer->stemWord($word);
var_dump($stem);
/*
string(4) "cycl"
*/

$algorithm = "basque";
$word = "aberatsenetakoa";
$stemmer = new Stemmer($algorithm, CharacterEncodingEnum::ISO_8859_1);
$stem = $stemmer->stemWord($word);
var_dump($stem);
/*
string(8) "aberatse"
*/
```

## License
All files are MIT &copy; [Andrea Maccis](https://twitter.com/andreamaccis) except for _resources/libstemmer.h_ BSD-3 &copy; [Snowball Project](https://github.com/snowballstem/snowball).